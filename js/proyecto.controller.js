(function () {
    'use strict';
    
    angular.module('app')
    .controller('InputCtrl',['$scope','$http','$uibModal', InputCtrl])
    .controller('ModalInstanceCtrl', ['$scope','$http','$uibModalInstance','$timeout','$cookies','tareas','tarea', ModalInstanceCtrl]);
    

    function ModalInstanceCtrl($scope, $http, $uibModalInstance,$timeout,$cookies, tareas, tarea) {
       
        var index        = tarea?tareas.indexOf(tarea):false;
        
        $scope.form = tarea;
        console.log( $scope.form);

        $scope.close = function()
        {
            /*var index = files.indexOf(item);
            
            if(index == -1)
            {
                files.push(item);
            }*/
            
            $uibModalInstance.close();
        }
        $scope.save = function()
        {

            if(tarea == false)            
                tareas.push($scope.form);


           var data = [];
//           data.push($scope.form);
                   //   $http.post(SITE_URL+'admin/proyectos/save_task', tareas:tareas).then('successCallback', 'errorCallback');
            $http.post(SITE_URL+'admin/proyectos/save_task',{data,id_proyecto:id_proyecto}).then(function(response){
                    
                    var result = response.data,
                          data = result.data;
                      },true);




           // $uibModalInstance.close();

            location.href =id_proyecto;



        }

    }

    function InputCtrl($scope,$http,$uibModal,logger)
    {

       $scope.tareas = tareas?tareas:[];
        console.log( $scope.tareas);

       
                
        $scope.modal_plan = function()
        {
                var modalInstance = $uibModal.open({
                			animation: true,
                            animation: $scope.animationsEnabled,
                            templateUrl: 'modal_plan.html',
                            controller: 'ModalInstanceCtrl',
                            //size: size,
                            resolve: {
      							tareas:function()
                                {
                                    return $scope.tareas;
                                },
                                tarea:function()
                                {
                                    return false;
                                },
                            }
                        });
         }

         $scope.delete_task = function(tarea)
        {
            
            if(tarea != false)
            {
                   //   $http.post(SITE_URL+'admin/proyectos/save_task', tareas:tareas).then('successCallback', 'errorCallback');
            $http.post(SITE_URL+'admin/proyectos/delete_task',{params:{id_tarea:tarea.id,id_proyecto:id_proyecto}}).then(function(response){
 },true);

            }

            
        }

        $scope.start_task = function(tarea)
        {
            
            
            console.log(tarea);
            if(tarea != false)
            {
                console.log(tarea.id);

                   //   $http.post(SITE_URL+'admin/proyectos/save_task', tareas:tareas).then('successCallback', 'errorCallback');
            $http.post(SITE_URL+'admin/proyectos/start_task',{params:{id_tarea:tarea.id,id_proyecto:id_proyecto}}).then(function(response){
                    
                    var result = response.data,
                          data = result.data;
                      },true);

            }

            
        }

        $scope.prepend_edit = function(tarea)
        {
            var modalInstance = $uibModal.open({
                            animation: true,
                            templateUrl: 'modal_plan.html',
                            controller: 'ModalInstanceCtrl',
                            //size: size,
                            resolve: {
                                tarea:function()
                                {
                                    return tarea;

                                },
                                tareas:function()
                                {
                                    return $scope.tareas;
                                }
                                /*equipos_left: function () {
                                    return $scope.equipos_left;
                                },
                                equipos_right: function () {
                                    return $scope.equipos_right;
                                },
                               
                                equipo:function()
                                {
                                    return equipo;
                                }*/
                                
                            }
            });
        }

    }
       

})();