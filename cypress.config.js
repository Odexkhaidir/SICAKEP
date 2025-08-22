import fs from "fs";
import path from "path";
import Papa from "papaparse";

export default {
    e2e: {
        setupNodeEvents(on, config) {
            on("task", {
                initCsv(header) {
                    const csv = Papa.unparse([], { delimiter: ";" });
                    const filePath = path.resolve(
                        "cypress/fixtures/output.csv"
                    );
                    fs.writeFileSync(filePath, csv, "utf8");
                    return null;
                },

                appendCsv(row) {
                    const filePath = path.resolve(
                        "cypress/fixtures/output.csv"
                    );
                    const csvLine = Papa.unparse([row], {
                        header: false,
                        delimiter: ";",
                    });
                    console.log("Appending row:", JSON.stringify(row));
                    fs.appendFileSync(filePath, csvLine + "\n", "utf8");
                    return null;
                },
                removeCsv() {
                    const filePath = path.resolve("cypress/fixtures/buku.csv");

                    // 1. Read the CSV file
                    const fileContent = fs.readFileSync(filePath, "utf8");

                    // 2. Parse CSV with header recognition
                    const parsed = Papa.parse(fileContent, {
                        header: true,
                        delimiter: ";",
                        skipEmptyLines: true,
                    });

                    const rows = parsed.data; // Array of row objects
                    const fields = parsed.meta.fields; // Column headers

                    // 3. Remove the first data row (if it exists)
                    if (rows.length > 0) {
                        rows.splice(0, 1);
                    }

                    // 4. Convert back to CSV with headers
                    const updatedCsv = Papa.unparse(rows, {
                        header: true,
                        delimiter: ";",
                        columns: fields,
                    });

                    // 5. Write updated CSV back to file
                    fs.writeFileSync(filePath, updatedCsv, "utf8");
                    return null;
                },
            });
        },
    },
};
