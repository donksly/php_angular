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
        <h2 align="center">ANIMUS - <i>edit apartment..</i></h2><br>
        <br><h4 align="center" id="invalid_forms_message"><code>Invalid Link, nothing to show!</code></h4>
        <input type="button" class="btn btn-primary" name="validate_token" id="submit_button" data-ng-click="show_data()" value="Load Details">
        <div class="col-m6-6" id="all_fill_forms">
            <br>
            <h5><strong>Apartment Details</strong></h5>
            <label for="name">Apartment name</label>
            <input type="text" id="name" name="name" data-ng-model="name" class="form-control" required>
            <br>
            <label for="move_in_date">Move in date (e.g. 1 January 2017)</label>
            <input type="text" id="move_in_dates" name="move_in_date" data-ng-model="move_in_date" class="form-control" required>
            <br>
            <label for="street">Street</label>
            <input type="text" id="street" name="street" data-ng-model="street" class="form-control" required>
            <br>
            <label for="postal_code">Postal code</label>
            <input type="text" id="postal_code" name="postal_code" data-ng-model="postal_code" class="form-control" required>
            <br>
            <label for="town">Town</label>
            <input type="text" id="town" name="town" data-ng-model="town" class="form-control" required>
            <br>
            <label for="country">Country</label>
            <input type="text" name="country" id="country" data-ng-model="country" class="form-control" required>
            <br>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" data-ng-model="email" class="form-control" required>
            <br>
            <input type="hidden" data-ng-model="id">
            <input type="hidden"  id="tokeninput" name="tokeninput" data-ng-model="tokeninput" class="form-control">
            <input type="hidden"  id="apartmentssss" data-ng-model="apartmentssss" name="apartmentssss" value="jdgsfyhjds">
            <input type="submit" class="btn btn-primary" name="update" id="submit_button" data-ng-click="update_data()" value="{{btnName}}">
        </div>
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
        //get current apartment details and post to form
        $scope.show_data = function(){
            //get token
            $scope.tokeninput = $('#tokeninput').val();
            //post token for validation
            $http.post("server_side/token_validate.php", {
                'token': $scope.tokeninput,
                'type': 'edit'
                }
            ).then(function (data) {
                //validate token
                if((angular.toJson(data['data']))=='"0"'){
                    //on invalid token
                    $('#all_fill_forms').hide();
                    $('#invalid_forms_message').css('display','inline');
                    $('#submit_button').css('display','none');
                }else{
                    //on validated token auto fill form with current apartment details
                    var json_result = angular.fromJson(data['data']);
                    $scope.name = json_result[0].name;
                    $scope.id = json_result[0].id;
                    $scope.move_in_date = json_result[0].move_in_date;
                    $scope.street = json_result[0].street;
                    $scope.postal_code = json_result[0].postal_code;
                    $scope.town = json_result[0].town;
                    $scope.country = json_result[0].country;
                    $scope.email = json_result[0].email;
                    $scope.btnName = "Update Details";
                }
            },function(e){
                //on connection error
                alert(e);
            });
        };

        //function that post updated details to server
        $scope.update_data = function(){
            //form validation
            if($scope.name == null){
                alert("Enter apartment name")
            }else if($scope.move_in_date == null){
                alert("Enter move in date")
            }else if($scope.street == null){
                alert("Enter street")
            }else if($scope.postal_code == null){
                alert("Enter postal code")
            }else if($scope.town == null){
                alert("Enter town")
            }else if($scope.country == null){
                alert("Enter country")
            }else if($scope.email == null){
                alert("Enter email")
            }else {
                //post to server
                $http.post("server_side/update_apartment.php", {
                    //get form details from app
                    'id': $scope.id,
                    'name': $scope.name,
                    'move_in_date': $scope.move_in_date,
                    'street': $scope.street,
                    'postal_code': $scope.postal_code,
                    'town': $scope.town,
                    'country': $scope.country,
                    'email': $scope.email
                    }
                ).then(function (data) {
                    //on validated token post new details to server
                    alert ('Apartment successfully updated.');
                    $('.all_errors_show_here').html(data);
                    $scope.name = null;
                    $scope.move_in_date = null;
                    $scope.street = null;
                    $scope.postal_code = null;
                    $scope.town = null;
                    $scope.country = null;
                    $scope.email = null;
                    $scope.show_data();
                },function(e){
                    //on connection error
                    alert(e);
                });
            }
        };
    });
</script>
</body>
</html>