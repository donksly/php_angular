<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="assets/images/Animus%20Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kepha | Animus task</title>
    <link rel="stylesheet" href="assets/vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fonts/css/font-awesome.min.css">
    <script src="assets/vendor/js/angular.min.js" type="application/javascript"></script>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
<div data-ng-app="animus_app" data-ng-controller="controller">
    <div class="col-md-12" id="home_head_area"><br>
        <div align="center"><img src="assets/images/Animus%20Logo.png" alt=""></div>
        <br>
        <h2 align="center">ANIMUS - <i>delete apartment..</i></h2><br>
        <br><h4 align="center" id="apartment_deleted_message"><code>Apartment was deleted!</code></h4>
        <input type="button" class="btn btn-primary" name="validate_token" id="submit_button" data-ng-click="delete_data()" value="Delete Apartment">
        <input type="hidden"  id="tokeninput" name="tokeninput" data-ng-model="tokeninput" class="form-control">
        <br>
    </div>
    <br>
</div>
<br><br>
<br><br>
<footer>
    <div class="pull-right">By: Kepha Okello</div>
</footer>
<script src="assets/js/jquery-3.3.1.min.js" type="application/javascript"></script>
<script src="assets/js/app.js" type="application/javascript"></script>
<script>
    //get app name from html
    var app = angular.module("animus_app", []);
    //declare controller requirements
    app.controller("controller", function($scope, $http){
        $scope.btnName = "Update Details";
        //delete apartment
        $scope.delete_data = function(){
            //get token
            $scope.tokeninput = $('#tokeninput').val();
            //post token for validation
            $http.post("server_side/token_validate.php", {
                'token': $scope.tokeninput,
                'type': 'delete'
                }
            ).then(function (data) {
                //validate token
                if((angular.toJson(data['data']))=='"0"'){
                    //on invalid token
                    $('#apartment_deleted_message').css('display','inline');
                    $('#submit_button').css('display','none');
                }else{
                    //on validated token
                    if(confirm("Are you sure you want to delete this apartment?")){
                        //on confirmed deletion
                        $http.post('server_side/delete_single.php', {
                            'token': $scope.tokeninput
                        }).then(function(data){
                            $('#apartment_deleted_message').css('display','inline');
                            $('#submit_button').css('display','none');
                            alert ('Apartment permanently deleted!');
                        });
                    }else{
                        //cancel deletion
                        return false;
                    }
                }
            },function(e){
                //show connection error
                alert(e);
            });
        };
    });
</script>
</body>
</html>