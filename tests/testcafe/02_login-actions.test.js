"@fixture 02_Login-actions";
"@page http://localhost/jdemevarit/prihlaseni.php";

"@test"["Add-new-recipe"] = {
    '1.Type in input "userEmail"': function() {
        act.type("#email", "test@test.cz");
    },
    '2.Type in password input "Heslo"': function() {
        act.type("#password", "123456");
    },
    '3.Click submit button "Přihlásit"': function() {
        act.click(":containsExcludeChildren(Pihlásit)");
    },
    "4 .Assert": function() {
        eq($("#login-success").length > 0, true);
    },
    '5. Navigate to the Recipes page': function () {
        act.navigateTo('http://localhost/jdemevarit/recepty.php');
    },
    "6.Assert": function() {
        eq($("#logout").find(" > u:nth(0)").length > 0, true);
    },
    '7.Click link "Přidat recept"': function() {
        act.click(":containsExcludeChildren(Pidat recept)");
    },
    '8.Type in input "Název receptu"': function() {
        act.type("#name", "Bábovka");
    },
    '9.Type in input "Seznam přísad"': function() {
        act.type("#RContent", "200ml Mléka, 500g Mouky, 1 Vejce");
    },
    '10.Type in input "Postup"': function() {
        act.type("#process", "Nějaký postup - upečeme a sníme...");
    },
    '9.Click check box "on"': function() {
        var actionTarget = function() {
            return $("#recipe").find("[name='limitation3']");
        };
        act.click(actionTarget);
    },
    '10.Click check box "on"': function() {
        var actionTarget = function() {
            return $("#recipe").find("[name='limitation4']");
        };
        act.click(actionTarget);
    },
    '11.Click submit button "Vytvořit"': function() {
        act.click(":containsExcludeChildren(Vytvoit)");
    },
    "12.Assert": function() {
        eq($("#recipe-added").length, 1);
    }
};