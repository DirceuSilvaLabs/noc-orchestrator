export class NocOrchestratorPage {
  navigateTo() {
    return browser.get('/');
  }

  getParagraphText() {
    return element(by.css('noc-orchestrator-app h1')).getText();
  }
}
