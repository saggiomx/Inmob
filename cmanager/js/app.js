'use strict';

/* App Module */

var managerModule = angular.module('manager', ['ResourcesService', 'ui.router', 'ui.bootstrap']);
managerModule.config(
    ['$stateProvider', '$routeProvider', '$urlRouterProvider',
    function ($stateProvider, $routeProvider, $urlRouterProvider) {

        $routeProvider
            .when('', {
                redirectTo: '/login'
            })
            .when('index.html', {
                redirectTo: '/login'
            });
        $urlRouterProvider.otherwise('/login')

            .state('login', {
                url: '/login',
                views: {
                    'navs@': {
                        templateUrl: 'partials/nolognav.html'
                    },
                    'body@': {
                        templateUrl: 'partials/login.html'
                    }
                }
            })


    }]).run(
      ['$rootScope', '$state', '$stateParams',
      function ($rootScope, $state, $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }]);


