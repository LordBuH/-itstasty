<?php
function GetSearchResult($search, $categories)
{
    include 'db_conn.php';

    function ReplaceObjectWithArray($obj)
    {
        $newArray = array();
        while($ob = mysqli_fetch_object($obj))
        {
            array_push($newArray, $ob);
        }
    
        return $newArray;
    }
    
    
    #$search = $_POST['search'];
    $counter = 0;
    $search = "%" . $search . "%";
    $sql_statment = 'SELECT recipe.* FROM recipe INNER JOIN categoriesrecipe ON categoriesrecipe.RecipeID=recipe.ID ';
    ##
    if (isset($categories))
    {
        #$categories = $_POST['categories'];
    
        foreach($categories as $cg)
        {
            if ($counter == 0)
            {
                $sql_statment = $sql_statment . ' AND ';
            }
            if($counter == max(array_keys($categories))) 
            {
                $sql_statment = $sql_statment . 'categoriesrecipe.CategoriesID = ' . $cg;
            } 
            else
            {
                $sql_statment = $sql_statment . 'categoriesrecipe.CategoriesID = ' . $cg . " OR ";
            }
            $counter = $counter + 1;
        }
    }
    
    
    $sql_statment = $sql_statment . ' WHERE recipe.Name LIKE ? GROUP BY recipe.ID';
    
    $stmt = $conn->prepare($sql_statment);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    
    ## result ##
    $result = $stmt->get_result();
    
    $recipeList = array();
    
    while($obj = mysqli_fetch_object($result))
    {
        $ingredientsList = array();
    
        ## Ingredients From Recipe ##
        $stmt = $conn->prepare('SELECT * FROM ingredientsrecipe WHERE RecipeID=?');
        $stmt->bind_param('s', $obj->ID);
        $stmt->execute();
    
        $ingredientsrecipes = $stmt->get_result();
    
        ## Ingedients ##
        $stmt = $conn->prepare('SELECT * FROM ingredients');
        $stmt->execute();
    
        $ingredients = $stmt->get_result();
        $ingredients = ReplaceObjectWithArray($ingredients);
    
        ## Quantitys ##
        $stmt = $conn->prepare('SELECT * FROM quantity');
        $stmt->execute();
    
        $quantitys = $stmt->get_result();
        $quantitys = ReplaceObjectWithArray($quantitys);
    
        #foreach($ingredientsrecipes as $dt)
        while($dr = mysqli_fetch_object($ingredientsrecipes))
        {
            #foreach($ingredients as $ig)
            foreach($ingredients as $ig)
            {
                if($dr->IngredientsID == $ig->ID)
                {
                    $dr->IngredientName = $ig->Name;
                }
            }
    
            #foreach($quantitys as $qt)
            foreach($quantitys as $qt)
            {
                
                if($dr->QuantityID == $qt->ID)
                {
                    $dr->quantityName = $qt->Description;
                }
            }
            $dr->quantityValue = $dr->QuantityValue;
            array_push($ingredientsList, $dr);
        }
    
        ## Commenets ##
        $stmt = $conn->prepare('SELECT * FROM comment WHERE RecipeID=?');
        $stmt->bind_param('s', $obj->ID);
        $stmt->execute();
    
        $data = $stmt->get_result();
    
        $obj->Comments = ReplaceObjectWithArray($data);
        $obj->ingredientsList = $ingredientsList;
    
        array_push($recipeList, $obj);
    }
    
    return $recipeList;
}
?>