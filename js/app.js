'use strict';

/* App Module */

var inmobModule = angular.module('inmob', ['ResourcesService', 'ui.router', 'ui.bootstrap']);

inmobModule.config(
    ['$stateProvider', '$routeProvider', '$urlRouterProvider',
    function ($stateProvider, $routeProvider, $urlRouterProvider) {

        $routeProvider
            .when('', {
                redirectTo: '/home'
            })
            .when('index.html', {
                redirectTo: '/home'
            });
        $urlRouterProvider.otherwise('/home')
        $stateProvider
            .state('home', {
                url: '/home',
                views: {
                    'body@': {
                        templateUrl: 'partials/home.html',
                        controller :'HomeCrtl'
                    }
                }
            })
            }]).run(
      ['$rootScope', '$state', '$stateParams',
      function ($rootScope, $state, $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }]);


