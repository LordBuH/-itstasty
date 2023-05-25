<?php

function GetTop3()
{
    include 'db_conn.php';

    $array_top3 = array();

    $stmt = $conn->prepare('SELECT recipe.*, AVG(RatingValue) AS avg FROM rating INNER JOIN recipe ON recipe.ID=rating.RecipeID GROUP BY recipe.ID');
    $stmt->execute();

    $result = $stmt->get_result();
    
    while($obj = mysqli_fetch_object($result))
    {
        array_push($array_top3, $obj);
    }

    return $array_top3;
}

function GetRecipeDataById($id)
{
    include 'db_conn.php';

    $array_recipe = array();

    $stmt = $conn->prepare('SELECT * FROM recipe WHERE ID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $result = $stmt->get_result();

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
    
        array_push($array_recipe, $obj);
    }

    return $array_recipe;
}

function CreateIngredient($name)
{
    include 'db_conn.php';

    $stmt = $conn->prepare('INSERT INTO ingredients (Name) VALUES(?)');
    $stmt->bind_param('s', $name);
    $stmt->execute();

    $ID = $stmt->insert_id;

    return $ID;
}

function GetIngredientID($name)
{
    include 'db_conn.php';
    $ingredientID = null;

    $stmt = $conn->prepare('SELECT * FROM ingredients WHERE Name LIKE ? LIMIT 1');
    $stmt->bind_param('s', $name);
    $stmt->execute();

    $result = $stmt->get_result();

    while($obj = mysqli_fetch_object($result)) 
    {
        $ingredientID = $obj->ID;
    }

    return $ingredientID;
}

function CreateRecipe($userID, $Name, $instruction, $Time, $RecipeImg, $categorie, $ingredientsList)
{
    $ingredients = array();

    foreach($ingredientsList as $igl)
    {
        $ingredient = new stdClass();
        $ingredient->ID = GetIngredientID($igl->Name);

        if(!$ingredient->ID)
        {
            $ingredient->ID = CreateIngredient($igl->Name);
        }

        $ingredient->QuantityID = $igl->QuantityID;
        $ingredient->QuantityValue = $igl->QuantityValue;

        array_push($ingredients, $ingredient);
    }

    include 'db_conn.php';

    ## CREATE RECIPE IN DATABASE AND RETURN ID FOR INGREDIENTS ## 
    $stmt = $conn->prepare('INSERT INTO recipe (UserID, Name, instruction, Time, RecipeImg) VALUES(?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $userID, $Name, $instruction, $Time, $RecipeImg);
    $stmt->execute();

    $ID = $stmt->insert_id;

    ## INSERT RECIPE_INGREDIENTS LIST ##
    foreach($ingredients as $igt)
    {
        AddIngredientToRecipe($igt, $ID);
    }

    $stmt = $conn->prepare('INSERT INTO categoriesrecipe (CategoriesID, RecipeID) VALUES(?, ?)');
    $stmt->bind_param('ss', $categorie, $ID);
    $stmt->execute();
}

function DeleteRecipe($id)
{
    include 'db_conn.php';

    $stmt = $conn->prepare('DELETE FROM ingredientsrecipe WHERE RecipeID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $stmt = $conn->prepare('DELETE FROM categoriesrecipe WHERE RecipeID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $stmt = $conn->prepare('DELETE FROM rating WHERE RecipeID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $stmt = $conn->prepare('DELETE FROM comment WHERE RecipeID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    $stmt = $conn->prepare('DELETE FROM recipe WHERE ID=?');
    $stmt->bind_param('s', $id);
    $stmt->execute();
}

function UpdateIngredientFromRecipe($ingredient, $RecipeID)
{
    include 'db_conn.php';
    $stmt = $conn->prepare('UPDATE ingredientsrecipe SET QuantityID=?, QuantityValue=? WHERE IngredientsID=? AND RecipeID=?');
    $stmt->bind_param('ssss', $ingredient->QuantityID, $ingredient->QuantityValue, $ingredient->ID, $RecipeID);
    $stmt->execute();
}

function AddRecipeComments($userID, $RecipeID, $Comment)
{
    include 'db_conn.php';
    $stmt = $conn->prepare('INSERT INTO comment (UserID, Comment, RecipeID) VALUES(?, ?, ?)');
    $stmt->bind_param('sss', $userID, $Comment, $RecipeID);
    $stmt->execute();
}

function AddRecipeRating($userID, $RecipeID, $Raiting)
{
    include 'db_conn.php';
    $stmt = $conn->prepare('INSERT INTO rating (UserID, Comment, RatingValue) VALUES(?, ?, ?)');
    $stmt->bind_param('sss', $userID, $Comment, $rating);
    $stmt->execute();
}

function AddIngredientToRecipe($ingredient, $RecipeID)
{
    include 'db_conn.php';
    $stmt = $conn->prepare('INSERT INTO ingredientsrecipe (IngredientsID, RecipeID , QuantityID, QuantityValue) VALUES(?, ?, ?, ?)  ON DUPLICATE KEY UPDATE IngredientsID=? AND RecipeID=?');
    $stmt->bind_param('ssssss', $ingredient->ID, $RecipeID, $ingredient->QuantityID, $ingredient->QuantityValue, $ingredient->ID, $RecipeID);
    $stmt->execute();
}


function UpdateRecipe($Recipe)
{
    include 'db_conn.php';

    ## Update Ingredients ##
    foreach($Recipe->ingredientsList as $rl)
    {
        if (isset($rl->ID))
        {
          UpdateIngredientFromRecipe($rl, $Recipe->ID);  
        }
        else
        {
            $ingredientID = GetIngredientID($rl->Name);
            if($ingredientID)
            {
                $rl->ID = $ingredientID;
                AddIngredientToRecipe($rl, $Recipe->ID);
                continue;
            }

            $ingredientID = CreateIngredient($rl->Name);
            $rl->ID = $ingredientID;
            AddIngredientToRecipe($rl, $Recipe->ID);
        }

    }

    if(isset($Recipe->categorie))
    {
        ## Get Categorie From Recipe ##
        $stmt = $conn->prepare('SELECT * FROM categoriesrecipe WHERE RecipeID=? LIMIT 1');
        $stmt->bind_param('s', $Recipe->ID);
        $stmt->execute();

        $result = $stmt->get_result();
        $categorie = null;

        while($obj = mysqli_fetch_object($result))
        {
            $categorie = $obj->ID;
        }


        ## Update Categorie ##
        if($categorie)
        {
            $stmt = $conn->prepare('UPDATE categoriesrecipe SET CategoriesID=? WHERE ID=?');
            $stmt->bind_param('ss', $Recipe->categorie, $categorie);
            $stmt->execute();
        }
    }

    ## Update Recipe ##
    $stmt = $conn->prepare('UPDATE recipe SET Name=?, instruction=?, Time=?, RecipeImg=? WHERE ID=?');
    $stmt->bind_param('sssss', $Recipe->Name, $Recipe->instruction, $Recipe->Time, $Recipe->RecipeImg, $Recipe->ID);
    $stmt->execute();
}


function GetRecipeWithIngredients($ingredients)
{
    include 'db_conn.php';
    
    
    $sql_statment = 'SELECT * FROM recipe ';
    $bind_param = "";

    foreach($ingredients as $igl)
    {
        $ID = GetIngredientID($igl);

        if(!$ID)
        {
            continue;
        }

        $sql_statment = $sql_statment . ' INNER JOIN ingredientsrecipe as t'.$ID.' on t'.$ID.'.RecipeID = recipe.ID and t'.$ID.'.IngredientsID='.$ID;
    }

    $stmt = $conn->prepare($sql_statment);
    $stmt->execute();

    $result = $stmt->get_result();

    $test = ReplaceObjectWithArray($result);

    foreach($test as $t)
    {

        echo "RECIPE = " . $t->RecipeID;
    }
}

function AddRecipeToFavorites($userID, $RecipeID)
{
    include 'db_conn.php';

    $stmt = $conn->prepare('INSERT INTO userfavorites (UserID, RecipeID) VALUES(?, ?)');
    $stmt->bind_param('ss', $userID, $RecipeID);
    $stmt->execute();
}

function RemoveRecipeToFavorites($userID, $RecipeID)
{
    include 'db_conn.php';

    $stmt = $conn->prepare('DELETE FROM userfavorites WHERE UserID=? AND RecipeID=?');
    $stmt->bind_param('ss', $userID, $RecipeID);
    $stmt->execute();
}

function IsUserRecipeFavorite($userID, $RecipeID)
{
    include 'db_conn.php';

    $stmt = $conn->prepare('SELECT * FROM userfavorites WHERE UserID=? AND RecipeID=? ');
    $stmt->bind_param('ss', $userID, $RecipeID);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if(!$row)
    {
        return false;
    }

    return true;
}

function CreateFavorCards($userID)
{
    include 'content.php';

    $recipeList = GetUserFavoriteRecipes($userID);

    GetCart($recipeList);
}

function GetUserFavoriteRecipes($userID)
{
    include 'db_conn.php';

    $recipeList = array();

    $stmt = $conn->prepare('SELECT RecipeID FROM userfavorites WHERE UserID=?');
    $stmt->bind_param('s', $userID);
    $stmt->execute();

    $result = $stmt->get_result();
    $result = ReplaceObjectWithArray($result);

    foreach($result as $rl)
    {
        $recipe = GetRecipeDataById($rl->RecipeID);

        foreach($recipe as $One)
        {
            array_push($recipeList, $One);
        }
    }

    return $recipeList;
}

function ReplaceObjectWithArray($obj)
{
    $newArray = array();
    while($ob = mysqli_fetch_object($obj))
    {
        array_push($newArray, $ob);
    }

    return $newArray;
}

?>