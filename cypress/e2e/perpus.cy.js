import Papa from "papaparse";

describe("Perjalanan Dinas > Menu Formulir", () => {
    it("hapus dan langsung tulis hasil per baris ke CSV", () => {
        cy.login_pst("pst7100", "pst7100");

        // Inisialisasi file output
        // cy.task("initCsv");
        cy.get('[href="#"] > :nth-child(2)')
            .click()
            .then(() => {
                cy.get(
                    ":nth-child(4) > .list-unstyled > :nth-child(1) > a"
                ).click();
            });
        cy.fixture("buku.csv").then((csvText) => {
            return new Promise((resolve) => {
                Papa.parse(csvText, {
                    header: true,
                    skipEmptyLines: true,
                    delimiter: ";",
                    complete: (results) => resolve(results.data),
                });
            }).then(async (records) => {
                for (const record of records) {
                    const nama_buku = record.judul_buku;

                    cy.get("#titlesingle").clear().type(nama_buku);
                    cy.get("#submitSearch").click();
                    cy.get("#searchLoader > img:nth-child(1)", {
                        timeout: 10000,
                    }).should("not.be.visible");

                    cy.get("#tableresult1 tbody tr", { timeout: 10000 }).then(
                        ($rows) => {
                            const matchingRows = Cypress._.filter(
                                $rows.toArray(),
                                (row) => {
                                    const secondCell = Cypress.$(row)
                                        .find("td:nth-child(2)")
                                        .text()
                                        .trim();
                                    return secondCell.includes(nama_buku);
                                }
                            );

                            let deleteCount = 0;

                            function processMatchingRow(index) {
                                if (index >= matchingRows.length) {
                                    cy.get(
                                        "tbody > tr:first-child > td:nth-child(3)"
                                    )
                                        .invoke("text")
                                        .then((expectedText) => {
                                            // 2. Build your resultRow now that you have the text value
                                            const resultRow = {
                                                judul_buku: nama_buku,
                                                delete_count:
                                                    deleteCount > 0
                                                        ? deleteCount
                                                        : "Tidak ada",
                                                // trim or parse as needed
                                                expected_delete_count:
                                                    expectedText.trim() ||
                                                    "Tidak ada",
                                            };

                                            // 3. Write it to CSV

                                            cy.task("appendCsv", resultRow);
                                            cy.task("removeCsv"); // Remove the first data row
                                        });
                                    return;
                                }

                                const row = matchingRows[index];
                                const hasButton =
                                    Cypress.$(row).find(
                                        ".btn-outline-success > .fa"
                                    ).length > 0;

                                if (hasButton) {
                                    cy.wrap(row)
                                        .find(".btn-outline-success > .fa")
                                        .click({ force: true });

                                    cy.get("#hardcopyTable tr").should(
                                        "be.visible"
                                    );

                                    function deleteNonPstRows() {
                                        return cy
                                            .get("#hardcopyTable")
                                            .then(($table) => {
                                                const tableText = $table.text();

                                                if (
                                                    $table.find("tr:visible")
                                                        .length === 0 ||
                                                    tableText.includes(
                                                        "No data available in table"
                                                    )
                                                ) {
                                                    return;
                                                }

                                                const visibleRows = Cypress.$(
                                                    "#hardcopyTable tr:visible"
                                                );

                                                // Iterate through rows
                                                for (
                                                    let i = 0;
                                                    i < visibleRows.length;
                                                    i++
                                                ) {
                                                    const $row = Cypress.$(
                                                        visibleRows[i]
                                                    );
                                                    const fourthCellText = $row
                                                        .find("td:nth-child(4)")
                                                        .text()
                                                        .trim();

                                                    if (
                                                        !fourthCellText.includes(
                                                            "PST"
                                                        )
                                                    ) {
                                                        // Found a row to delete
                                                        cy.wrap($row)
                                                            .find(
                                                                ".deletehardcopy"
                                                            )
                                                            .should("exist")
                                                            .click({
                                                                force: true,
                                                            });

                                                        cy.wait(1500);

                                                        return cy
                                                            .get(
                                                                "#hardcopyTable"
                                                            )
                                                            .should(
                                                                ($newTable) => {
                                                                    const newText =
                                                                        $newTable.text();
                                                                    expect(
                                                                        newText
                                                                    ).to.not.eq(
                                                                        tableText
                                                                    );
                                                                }
                                                            )
                                                            .then(() => {
                                                                deleteCount++;
                                                                return deleteNonPstRows(); // 🔁 restart from top
                                                            });
                                                    }
                                                }

                                                // If we got here, no non-PST rows were found
                                            });
                                    }

                                    deleteNonPstRows().then(() => {
                                        const closeSelector =
                                            "#manageHardcopyModal .modal-header .close > span";

                                        cy.get("body").then(($body) => {
                                            if (
                                                $body
                                                    .find(closeSelector)
                                                    .is(":visible")
                                            ) {
                                                cy.get(closeSelector).click({
                                                    force: true,
                                                });
                                            }
                                        });

                                        cy.wait(300).then(() => {
                                            cy.get("body").then(($body) => {
                                                if (
                                                    $body
                                                        .find(closeSelector)
                                                        .is(":visible")
                                                ) {
                                                    cy.get(closeSelector).click(
                                                        { force: true }
                                                    );
                                                }
                                            });

                                            processMatchingRow(index + 1); // ➡️ next row
                                        });
                                    });
                                } else {
                                    processMatchingRow(index + 1); // ➡️ skip to next
                                }
                            }

                            // ✅ start processing
                            processMatchingRow(0);
                        }
                    );
                    const randomDelay =
                        Math.floor(Math.random() * (5000 - 2500 + 1)) + 2500;
                    cy.wait(randomDelay); // Wait between 2.5–5 seconds
                }
            });
        });
    });
});
