define(['mage/storage'], function (storage) {
    'use strict';

    return {
        getList: async function () {
            return await storage.get('rest/V1/covids/list');
        }
    }
});
