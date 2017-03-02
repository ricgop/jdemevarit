"@fixture Registration";
"@page http://127.0.0.1/jdemevarit/registrace.php";



"@test"["registration-wrong"] = {
    '1.Click submit button "Registrovat"': function() {
        var actionTarget = function() {
            return $("#registration-container").find(".btn.btn-primary");
        };
        act.click(actionTarget);
    },
    "2.Assert": function() {
        eq($("#form-email").find(".error").text(), "Neplatný email!");
        eq($("#form-name").find(".error").text(), "Uživateslké jméno nesmí být prázdné!");
        eq($("#form-password1").find(".error").text(), "Heslo nesmí být prázdné!");
        eq($("#form-password2").find(".error").text(), "Heslo nesmí být prázdné!");
    },
    '3.Type in input "Email"': function() {
        act.type("#email", "test@test.cz");
    },
    '4.Type in input "Přezdívka"': function() {
        act.type("#name", "test1");
    },
    '5.Type in password input "Heslo"': function() {
        act.type("#password1", "123456");
    },
    '6.Type in password input "Heslo (pro..."': function() {
        act.type("#password2", "12345");
    },
    '7.Click submit button "Registrovat"': function() {
        act.click(":containsExcludeChildren(Registrovat)");
    },
    "8.Assert": function() {
        eq($("#form-password1").find(".error").text(), "Hesla se musí shodovat!");
    }
};

"@test"["registration-correct"] = {
    '1.Type in input "Email"': function() {
        act.type("#email", "test@test.cz");
    },
    '2.Type in input "Přezdívka"': function() {
        act.type("#name", "test1");
    },
    '3.Type in password input "Heslo"': function() {
        act.type("#password1", "123456");
    },
    '4.Type in password input "Heslo (pro..."': function() {
        act.type("#password2", "123456");
    },
    '5.Click check box "on"': function() {
        var actionTarget = function() {
            return $("#registration").find("[name='limitation1']");
        };
        act.click(actionTarget);
    },
    '6.Click check box "on"': function() {
        var actionTarget = function() {
            return $("#registration").find("[name='limitation3']");
        };
        act.click(actionTarget);
    },
    '7.Click submit button "Registrovat"': function() {
        act.click(":containsExcludeChildren(Registrovat)");
    },
    "8.Assert": function() {
        eq($("#login").length > 0, true);
    }
};

