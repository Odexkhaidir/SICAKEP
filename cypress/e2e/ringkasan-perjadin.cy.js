describe("Perjalanan Dinas > Menu Formulir", () => {
    beforeEach(() => {
        cy.login("ilham", "password");
        cy.visit("http://localhost:8000/perjadin/ringkasan");
    });

    // cy.login("ilham", "password");
    // cy.visit("http://localhost:8000/perjadin/formulir");
    it("apakah halaman tersedia", () => {
        cy.get("#year").select("2025");
        cy.get("#month").select("7");
        cy.get("tbody tr").its("length").should("be.gt", 1);
    });
    it("bisa menambahkan formulir baru", () => {
        let countBefore;

        cy.get("body").then(($body) => {
            if ($body.find(".text-sm > :nth-child(3)").length > 0) {
                // Element exists
                cy.get(".text-sm > :nth-child(3)")
                    .invoke("text")
                    .then((text) => {
                        countBefore = parseInt(text);
                        cy.log("Count before (from element): " + countBefore);
                    });
            } else {
                // Element does not exist, use tbody tr length instead
                cy.get("tbody tr").then(($rows) => {
                    countBefore = $rows.length;
                    cy.log("Count before (from tbody): " + countBefore);
                });
            }
        });

        cy.get("#create-summary-btn").click();
        cy.get("#formulir_id")
            .find("option")
            .eq(1)
            .then((option) => {
                cy.get("#formulir_id").select(option.val());
            });
        cy.get("#jadwal").click();
        cy.get(
            '.left > .calendar-table > .table-condensed > tbody > :nth-child(4) > [data-title="r3c2"]'
        ).click();
        cy.get(
            '.left > .calendar-table > .table-condensed > tbody > :nth-child(5) > [data-title="r4c4"]'
        ).click();
        cy.get(".applyBtn").click();
        cy.get("input[name='tujuan_supervisi']").type("Pemeriksaan Kinerja");
        cy.get("select[name='fungsi']").select("Supervisi SDM");
        cy.get("textarea[name='temuan']").type(
            "Ada beberapa perbaikan yang perlu dilakukan"
        );
        cy.get("textarea[name='rekomendasi']").type(
            "Perkuatkan sistem pengawasan dan pengendalian keuangan"
        );

        cy.contains("Simpan").click();
        cy.get("body").then(($body) => {
            if ($body.find(".text-sm > :nth-child(3)").length > 0) {
                cy.get(".text-sm > :nth-child(3)")
                    .invoke("text")
                    .then((text) => {
                        const countAfter = parseInt(text);
                        cy.log("Count after (from element): " + countAfter);
                        expect(countAfter).to.equal(countBefore + 1);
                    });
            } else {
                cy.get("tbody tr").then(($rows) => {
                    const countAfter = $rows.length;
                    cy.log("Count after (from tbody): " + countAfter);
                    expect(countAfter).to.equal(countBefore + 1);
                });
            }
        });
    });

    it("bisa mengedit formulir", () => {
        cy.get(":nth-child(1) > .project-actions > .btn-info").click();
        cy.get("#jadwal").click();
        cy.get(
            '.left > .calendar-table > .table-condensed > tbody > :nth-child(4) > [data-title="r3c2"]'
        ).click();
        cy.get(
            '.left > .calendar-table > .table-condensed > tbody > :nth-child(5) > [data-title="r4c4"]'
        ).click();
        cy.get(".applyBtn").click();
        cy.get("input[name='tujuan_supervisi']")
            .clear()
            .type("Pemeriksaan Kinerja Edited1");
        cy.get("select[name='fungsi']").select("Supervisi Teknis");
        cy.get("textarea[name='temuan']")
            .clear()
            .type("Ada beberapa perbaikan yang perlu dilakukan Edited2");
        cy.get("textarea[name='rekomendasi']")
            .clear()
            .type(
                "Perkuatkan sistem pengawasan dan pengendalian keuangan Edited3"
            );

        cy.contains("Simpan").click();
        cy.get("tbody tr").first().contains("Pemeriksaan Kinerja Edited1");
        cy.get("tbody tr").first().contains("Supervisi Teknis");
        cy.get("tbody tr").first().contains("Edited2");
        cy.get("tbody tr").first().contains("Edited3");
    });

    // return;
    it("bisa menghapus formulir", () => {
        let countBefore;

        cy.get("body").then(($body) => {
            if ($body.find(".text-sm > :nth-child(3)").length > 0) {
                // Element exists
                cy.get(".text-sm > :nth-child(3)")
                    .invoke("text")
                    .then((text) => {
                        countBefore = parseInt(text);
                        cy.log("Count before (from element): " + countBefore);
                    });
            } else {
                // Element does not exist, use tbody tr length instead
                cy.get("tbody tr").then(($rows) => {
                    countBefore = $rows.length;
                    cy.log("Count before (from tbody): " + countBefore);
                });
            }
        });
        // cy.get(".ml-3").click();
        cy.get("tbody tr").last().as("rowToDelete");
        cy.get("@rowToDelete").find(".btn-danger").click();
        cy.get(".modal-footer > .btn-danger").click();
        cy.wait(500); // wait for deletion to complete if needed
        cy.get("body").then(($body) => {
            if ($body.find(".text-sm > :nth-child(3)").length > 0) {
                cy.get(".text-sm > :nth-child(3)")
                    .invoke("text")
                    .then((text) => {
                        const countAfter = parseInt(text);
                        cy.log("Count after (from element): " + countAfter);
                        expect(countAfter).to.equal(countBefore - 1);
                    });
            } else {
                cy.get("tbody tr").then(($rows) => {
                    const countAfter = $rows.length;
                    cy.log("Count after (from tbody): " + countAfter);
                    expect(countAfter).to.equal(countBefore - 1);
                });
            }
        });
    });
});
