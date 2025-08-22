describe("Perjalanan Dinas > Menu Formulir", () => {
    it("hapus 1 dulu", () => {
        cy.login_pst("pst7100", "pst7100");

        const arrays = [
            "KECAMATAN TAHUNAN DALAM ANGKA 2011",
            "PETA TEMATIK PENDATAAN USAHA TANI 2009 KOMODITAS TEBU 2009",
            // ... others omitted for brevity
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
                            } else {
                                cy.log(`Skipped (contains PST): ${fourthCell}`);
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
