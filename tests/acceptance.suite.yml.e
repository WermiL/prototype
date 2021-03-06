suite_namespace: frontend\tests\acceptance
actor: AcceptanceTester
modules:
    enabled:
        - WebDriver:
            url: http://yii2:80
            browser: firefox
        - Yii2:
            part: init
