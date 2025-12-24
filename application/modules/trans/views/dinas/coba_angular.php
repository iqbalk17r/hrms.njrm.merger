<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<html>
<head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body ng-app="myapp" ng-controller="myctrl">
<!--<form method="post"  ng-submit="add(car_det)">-->
<!--    Car name : <input type="text" ng-model="car_det.cname" name="name"><br>-->
<!--    Car Image : <input type="file" custom-on-change="uploadFile" ng-model="car_det.cimage"><br>-->
<!--    <input type="submit" name="add">-->
<!--</form>-->
<br>
<table>
<!--    <tr><td>ID </td><td>Car Name</td><td>Car Image</td></tr>-->
<!--    <tr ng-repeat="x in otherdata">-->
<!--        <td>{{x.id}}</td><td>{{x.cname}}</td><td>{{x.cimage}}</td>-->
<!--    </tr>-->
</table>
</body>
</html>
<!--<pre>--><?//= json_encode($list_deklarasi, JSON_PRETTY_PRINT) ?><!--</pre>-->
<pre>{{list_deklarasi | json}}</pre>


<script type="text/javascript">
    var app = angular.module("myapp", []);
    //var data = JSON.parse('<?php //echo json_encode($this->_ci_cached_vars) ?>//');
    app.controller("myctrl", function($scope, $http) {
        $scope.list_deklarasi = JSON.parse('<?php echo json_encode($list_deklarasi) ?>');

        // console.log(data)
        // data.forEach(function (d) {
        //     console.log(data)
        // });

        //$http.get("<?//=base_url()?>//trans/dinas/deklarasi_dinas_tmp").then(function(response){
        //     $scope = JSON.parse(data);
        //     $scope.push(JSON.parse(data));
            // $scope.otherdata = response.data;
        // });
        deklarasi($scope);
    });

    function deklarasi(scope) {
        console.log(scope.list_deklarasi);
    }
</script>