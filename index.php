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
<div data-ng-app="animus_app" data-ng-controller="controller" data-ng-init="show_data()">
<div class="col-md-12" id="home_head_area"><br>
    <div align="center"><img src="assets/images/Animus%20Logo.png" alt=""></div>
    <h2 align="center">ANIMUS</h2>
    <h5><code>Add Apartments</code></h5>
    <div class="col-m6-6">
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
        <input type="submit" class="btn btn-primary" name="insert" id="submit_button" data-ng-click="insert()" value="{{btnName}}">
    </div>
    <br>
</div>
<br>
<div class="row col-md-12">
    <div class="col-md-12">
        <h5><code>All Apartments</code></h5><br>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Apartment name</th>
                <th>Move in date</th>
                <th>Street</th>
                <th>Postal code</th>
                <th>Town</th>
                <th>Country</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr data-ng-repeat="x  in apartments">
                <td>{{$index +1}}</td>
                <td>{{x.name}}</td>
                <td>{{x.move_in_date}}</td>
                <td>{{x.street}}</td>
                <td>{{x.postal_code}}</td>
                <td>{{x.town}}</td>
                <td>{{x.country}}</td>
                <td>{{x.email}}</td>
                <td>
                    <button class="btn btn-info btn-xs" id="edit_list" data-ng-click="update_data(x.id, x.name,x.move_in_date, x.street, x.postal_code, x.town, x.country, x.email)">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger btn-xs" data-ng-click="delete_data(x.id)">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </td>
            </tr>
        </table>
    </div>
</div>
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
    var app = angular.module("animus_app",[]);
    //declare controller requirements
    app.controller("controller", function($scope, $http){
        $scope.btnName = "Save Apartment";
        //function to add apartment
        $scope.insert = function(){
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
                $http.post(
                    "server_side/add_apartment.php", {
                        //get form details from app
                        'name': $scope.name,
                        'move_in_date': $scope.move_in_date,
                        'street': $scope.street,
                        'postal_code': $scope.postal_code,
                        'town': $scope.town,
                        'country': $scope.country,
                        'email': $scope.email,
                        'btnName': $scope.btnName,
                        'id': $scope.id
                    }
                ).then(function (data) {
                    //on successful post
                    alert ('Apartment successfully added.');
                    $('.all_errors_show_here').html(data);
                    $scope.name = null;
                    $scope.move_in_date = null;
                    $scope.street = null;
                    $scope.postal_code = null;
                    $scope.town = null;
                    $scope.country = null;
                    $scope.email = null;
                    $scope.btnName = "Save Apartment";
                    $scope.show_data();
                },function(e){
                    //on post failure
                    alert(e);
                });
            }
        };
        //fetch and list all apartments
        $scope.show_data = function(){
            $http.get('server_side/display.php')
                .then(function(data){
                    $scope.apartments = data.data;
                });
        };

        //update apartment details from list
        $scope.update_data = function(id,name,move_in_date,street,postal_code,town,country,email){
            $scope.id = id;
            $scope.name = name;
            $scope.move_in_date = move_in_date;
            $scope.street = street;
            $scope.postal_code = postal_code;
            $scope.town = town;
            $scope.country = country;
            $scope.email = email;
            $scope.btnName = "Update Details";
            $scope.show_data();
        };

        //delete apartment
        $scope.delete_data = function(id){
            if(confirm("Are you sure you want to delete this apartment")){
                $http.post('server_side/delete.php', {
                    'id':id
                }).then(function(data){
                    $scope.show_data();
                    alert ('Apartment permanently deleted!');
                });
            }else{
                return false;
            }
        }

    });
</script>
</body>
</html>
