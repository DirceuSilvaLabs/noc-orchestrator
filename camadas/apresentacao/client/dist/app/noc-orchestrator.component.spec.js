"use strict";
var testing_1 = require('@angular/core/testing');
var noc_orchestrator_component_1 = require('../app/noc-orchestrator.component');
testing_1.beforeEachProviders(function () { return [noc_orchestrator_component_1.NocOrchestratorAppComponent]; });
testing_1.describe('App: NocOrchestrator', function () {
    testing_1.it('should create the app', testing_1.inject([noc_orchestrator_component_1.NocOrchestratorAppComponent], function (app) {
        testing_1.expect(app).toBeTruthy();
    }));
    testing_1.it('should have as title \'noc-orchestrator works!\'', testing_1.inject([noc_orchestrator_component_1.NocOrchestratorAppComponent], function (app) {
        testing_1.expect(app.title).toEqual('noc-orchestrator works!');
    }));
});
//# sourceMappingURL=noc-orchestrator.component.spec.js.map