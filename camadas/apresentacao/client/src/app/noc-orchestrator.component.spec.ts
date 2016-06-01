import {
  beforeEachProviders,
  describe,
  expect,
  it,
  inject
} from '@angular/core/testing';
import { NocOrchestratorAppComponent } from '../app/noc-orchestrator.component';

beforeEachProviders(() => [NocOrchestratorAppComponent]);

describe('App: NocOrchestrator', () => {
  it('should create the app',
      inject([NocOrchestratorAppComponent], (app: NocOrchestratorAppComponent) => {
    expect(app).toBeTruthy();
  }));

  it('should have as title \'noc-orchestrator works!\'',
      inject([NocOrchestratorAppComponent], (app: NocOrchestratorAppComponent) => {
    expect(app.title).toEqual('noc-orchestrator works!');
  }));
});
