describe("Perjalanan Dinas > Menu Formulir", () => {
    // beforeEach(() => {
    //     cy.login("ridwanst", "password");
    //     cy.visit("http://localhost:8000/capaian-kinerja/target");
    // });
    it("pengguna yang tidak terotorisasi tidak bisa mengakses halaman target kinerja", () => {
        cy.login("ilham", "password");
        cy.visit("http://localhost:8000/capaian-kinerja/target");
        cy.url().should("not.include", "/capaian-kinerja/target");
        // cy.get("h1").should("not.contain", "Target Kinerja");
    });
    it("bisa mengakses halaman target kinerja", () => {
        cy.url().should("include", "/capaian-kinerja/target");
        cy.get("h1").should("contain", "Target Kinerja");
    });

    it("apakah halaman tersedia dan dapat filter sesuai tahun dan satuan kerja", () => {
        // Buka dropdown Select2 untuk #year
        cy.get("#year").next(".select2-container").click();

        // Klik opsi 2025 dari dropdown yang terbuka
        cy.get(".select2-results__option").contains("2025").click();
        cy.get("#satker").next(".select2-container").click();
        cy.get(".select2-results__option")
            .contains("BPS Provinsi Sulawesi Utara")
            .click();

        cy.get("tbody tr").should("have.length.at.least", 1);

        // Verifikasi teks indikator tertentu
        cy.contains(
            "Target Kinerja 1 untuk BPS Provinsi Sulawesi Utara"
        ).should("exist");

        // Verifikasi salah satu badge progress memiliki kelas warna (opsional)
        cy.get("tbody tr")
            .first()
            .find(".badge")
            .invoke("text")
            .then((text) => {
                expect(text.trim()).to.match(/\d+(\.\d+)?%/); // format persen
            });
    });
    return;

    it("bisa menambahkan formulir baru", () => {
        let countBefore = 0;

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

                cy.get("tbody").then(($tbody) => {
                    const $rows = $tbody.find("tr");
                    if ($rows.length === 0) {
                        countBefore = 0;
                    } else {
                        countBefore = $rows.length;
                    }
                    cy.log("Count before (from tbody): " + countBefore);
                });
            }
        });

        cy.get("#create-summary-btn").click();
        cy.get("select[name='year']").select("2025");
        // cy.get("select[name='month']").select("6");

        cy.get("select[name='formulir']")
            .find("option")
            .eq(1)
            .then((option) => {
                cy.get("select[name='formulir']").select(option.val());
            });

        cy.get('input[type="file"]').attachFile("dummy.pdf");

        cy.get("input[type='submit']").click();
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
        let originalFileName;
        cy.get("tbody > tr > :nth-child(4)").then(($el) => {
            originalFileName = $el.text();
            cy.log(originalFileName);
        });
        cy.get(":nth-child(1) > .project-actions > .btn-info").click();
        cy.get('input[type="file"]').attachFile("dummy2.pdf");
        cy.contains("Simpan").click();
        cy.get("tbody > tr > :nth-child(4)").then(($el) => {
            const editedFileName = $el.text();
            cy.log(editedFileName);
            expect(editedFileName).to.not.equal(originalFileName);
        });
        // make sure the file is exists
        cy.get("tbody > tr > :nth-child(4)").then(($el) => {
            const fileName = $el.text();
            // Get the link from the "view" action button in the same row
            cy.get("tbody tr")
                .first()
                .find(".btn-primary")
                .then(($btn) => {
                    const url = $btn.attr("href");
                    cy.request({
                        url,
                        failOnStatusCode: false,
                    }).then((response) => {
                        expect(response.status).to.be.within(200, 299);
                        expect(response.headers["content-type"]).to.include(
                            "application/pdf"
                        );
                    });
                });
        });
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
                cy.get("tbody").then(($tbody) => {
                    const $rows = $tbody.find("tr");
                    // let countBefore;
                    if ($rows.length === 0) {
                        countBefore = 0;
                    } else {
                        countBefore = $rows.length;
                    }
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
                cy.get("tbody").then(($tbody) => {
                    const $rows = $tbody.find("tr");
                    let countAfter;
                    if ($rows.length === 0) {
                        countAfter = 0;
                    } else {
                        countAfter = $rows.length;
                    }
                    cy.log("Count after (from tr): " + countAfter);
                    expect(countAfter).to.equal(countBefore - 1);
                });
            }
        });
    });
});
