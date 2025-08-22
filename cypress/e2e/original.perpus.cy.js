describe("Perjalanan Dinas > Menu Formulir", () => {
    it("hapus 1 dulu", () => {
        cy.login_pst("pst7100", "pst7100");

        const arrays = [
            // "KEADAAN PEKERJA DI INDONESIA FEBRUARI 2008",
            // "STATISTIK DAERAH KOTA MANADO 2017",
            // "STATISTIK DAERAH KECAMATAN ERIS 2014",
            // "STATISTIK DAERAH KECAMATAN TOMOHON TIMUR 2016",
            // "KECAMATAN POSIGADAN DALAM ANGKA 2014",
            // "KECAMATAN PINOLOSIAN DALAM ANGKA 2014",
            // "KECAMATAN RATAHAN TIMUR DALAM ANGKA 2014",
            // "KECAMATAN SILIAN RAYA DALAM ANGKA 2014",
            // "KECAMATAN KOTAMOBAGU UTARA DALAM ANGKA 2015",
            // "KECAMATAN NUANGAN DALAM ANGKA 2015",
            // "KECAMATAN TUTUYAN DALAM ANGKA 2015",
            // "KECAMATAN MODAYAG DALAM ANGKA 2015",
            // "KECAMATAN TAHUNAN DALAM ANGKA 2014",
            "STATISTIK DAERAH KECAMATAN TOMOHON BARAT 2016",
        ];

        arrays.forEach((nama_buku) => {
            cy.get('[href="#"] > :nth-child(2)').click();
            cy.get(
                ":nth-child(4) > .list-unstyled > :nth-child(1) > a"
            ).click();
            cy.get("#titlesingle").clear().type(nama_buku);
            cy.get("#submitSearch").click();

            cy.get("#tableresult1 tbody tr").each(($row) => {
                const secondCell = $row.find("td:nth-child(2)").text().trim();

                if (secondCell.includes(nama_buku)) {
                    cy.log(`Matching row: ${secondCell}`);

                    const hasButton =
                        $row.find(".btn-outline-success > .fa").length > 0;
                    if (hasButton) {
                        cy.wrap($row)
                            .find(".btn-outline-success > .fa")
                            .click({ force: true });

                        // Wait for hardcopy table to be populated (optional: depends on behavior)
                        cy.get("#hardcopyTable").should("exist");

                        cy.get("#hardcopyTable tr").each(($hRow) => {
                            const fourthCell = $hRow
                                .find("td:nth-child(4)")
                                .text()
                                .trim();

                            if (!fourthCell.includes("PST")) {
                                cy.log(`Deleting row: ${fourthCell}`);
                                cy.wrap($hRow)
                                    .find(".btn-outline-danger")
                                    .click({ force: true });
                                cy.get(
                                    "#manageHardcopyModal > .modal-dialog > .modal-content > .modal-header > .close > span"
                                ).click();
                            } else {
                                cy.log(`Skipped (contains PST): ${fourthCell}`);
                            }
                        });
                        const selector =
                            "#manageHardcopyModal > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > button:nth-child(2)";

                        // First click
                        cy.get(selector).click({ force: true });

                        // Wait a bit to allow modal to close (or check visibility)
                        cy.wait(300); // optional, depends on UI speed

                        // Second click, only if button still visible
                        cy.get("body").then(($body) => {
                            if ($body.find(selector).is(":visible")) {
                                cy.get(selector).click({ force: true });
                            } else {
                                cy.log(
                                    "Second click skipped — element not visible"
                                );
                            }
                        });
                    } else {
                        cy.log(
                            "No '.btn-outline-success > .fa' button found in this row."
                        );
                    }
                } else {
                    cy.log(
                        `Skipping: ${secondCell} does not match ${nama_buku}`
                    );
                }
            });
        });
    });
});
