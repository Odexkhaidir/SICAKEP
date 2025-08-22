// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
import "cypress-file-upload";
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

Cypress.Commands.add("login", (email, password) => {
    cy.visit("http://localhost:8000"); // Sesuaikan dengan URL login kamu
    cy.get("#username").type(email);
    cy.get("#password").type(password);
    cy.contains("Log In").click();
});
Cypress.Commands.add("login_pst", (email, password) => {
    cy.visit("https://perpustakaan.bps.go.id/digilib/admin/login"); // Sesuaikan dengan URL login kamu
    cy.get("#username").type(email);
    cy.get("#password").type(password);
    cy.contains("Login").click();
});
