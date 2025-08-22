describe("Perjalanan Dinas > Menu Formulir", () => {
    beforeEach(() => {
        cy.login("ilham", "password");
        cy.visit("http://localhost:8000/perjadin/formulir");
    });

    // cy.login("ilham", "password");
    // cy.visit("http://localhost:8000/perjadin/formulir");
    // return;
    it("apakah halaman tersedia", () => {
        cy.get("#year").select("2025");
        cy.get("tbody tr").its("length").should("be.at", 1);
        // cy.get("#month").select("6");
    });
    // return;
    it("bisa menambahkan formulir baru", () => {
        cy.get("button[data-target='#modal-lg']").click();
        cy.get("input[name='nama_supervisi']").type("Formulir Baru");
        cy.get("select[name='tahun']").select("2025");
        // cy.get("select[name='bulan']").select("6");
        cy.get("input[name='link']").type("http://example.com/newnewform");
        cy.contains("Simpan").click();
    });
    it("bisa mengedit formulir", () => {
        cy.get(":nth-child(1) > .project-actions > .btn-info").click();
        cy.get("input[name='nama_supervisi']").clear().type("Formulir Edited");
        cy.get("select[name='tahun']").select("2025");
        // cy.get("select[name='bulan']").select("6");
        cy.get("input[name='link']").clear().type("http://example.com/edited");
        cy.contains("Simpan").click();
        cy.get("tbody tr").first().contains("Formulir Edited");
        cy.get("tbody tr").first().contains("http://example.com/edited");
    });
    it("bisa menghapus formulir", () => {
        let countBefore;
        cy.get(".text-sm > :nth-child(3)").then(($count) => {
            countBefore = Number($count.text());
        });
        cy.get(".ml-3").click();
        cy.get("tbody tr").last().as("rowToDelete");
        cy.get("@rowToDelete").find(".btn-danger").click();
        cy.get(".modal-footer > .btn-danger").click();
        cy.wait(500); // wait for deletion to complete if needed
        // Ensure the row is no longer visible
        // cy.get("@rowToDelete").should("not.exist");
        // Try to visit the edit page of the deleted formulir
        cy.get("@rowToDelete")
            .invoke("attr", "data-id")
            .then((deletedId) => {
                if (deletedId) {
                    cy.visit(
                        `http://localhost:8000/perjadin/formulir/${deletedId}/edit`
                    );
                    // Assert that the page shows not found or error
                    cy.contains("Not Found").should("exist");
                }
            });
        // Verify the count after deletion
        cy.get(".text-sm > :nth-child(3)").should(($count) => {
            const countAfter = Number($count.text());
            expect(countAfter).to.equal(countBefore - 1);
        });
    });
});
