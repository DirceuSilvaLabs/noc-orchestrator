import { NocOrchestratorPage } from './app.po';

describe('noc-orchestrator App', function() {
  let page: NocOrchestratorPage;

  beforeEach(() => {
    page = new NocOrchestratorPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('noc-orchestrator works!');
  });
});
