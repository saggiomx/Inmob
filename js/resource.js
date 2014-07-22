'use strict';

/* Service */
/*http://docs.angularjs.org/api/ngResource.$resource*/
angular.module('ResourcesService', ['ngResource'])
.factory('HomeResource', ['$resource', function ($resource) {
    return $resource(''
        , {
            'get': { method: 'GET' }
        });
}])
