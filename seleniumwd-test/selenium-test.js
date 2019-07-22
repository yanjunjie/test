let webdriver = require('selenium-webdriver');
// webdriver.Browser // to see the availabel list of browsers
let driver = new webdriver.Builder().forBrowser('chrome').build();
driver.get('http://www.google.com'); // go to google.com
driver.findElement(webdriver.By.name('q')).sendKeys('Hello World');
//driver.findElement({name: 'q'}).sendKeys('webdriverjs');
driver.findElement({ xpath: '(//input[@class="gNO89b"])[2]' }).click();
//driver.findElement(webdriver.By.className('gNO89b')).click();
//driver.findElement({name: 'q'}).sendKeys(webdriver.key.ENTER);
driver.wait(webdriver.until.elementLocated({ xpath: `//h3[text()='"Hello, World!" program - Wikipedia']` }, 1000));
driver.findElement({ xpath:`//h3[text()='"Hello, World!" program - Wikipedia']` }).click();
driver.getTitle().then(title=>console.log(title));
//driver.quit();
