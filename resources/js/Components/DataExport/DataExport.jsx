import React, {useRef, useState} from "react";
import {Button} from "reactstrap";
import html2pdf from 'html2pdf.js';
import { CopyToClipboard } from 'react-copy-to-clipboard';
import AlertModal from "@/components/AlertModal/index.jsx";

const DataExport = ({filteredData}) => {

    const [copied, setCopied] = useState(false);

    const tableRef = useRef();
    const prepareDataForCSV = () => {
        return filteredData.map(row => ({
            'Role Name': row.role_name,
            Status: row.status,
            // Add other fields as required
        }));
    };

    const exportToCSV = () => {
        const csvData = prepareDataForCSV();
        const header = Object.keys(csvData[0]);

        const csvContent =
            'data:text/csv;charset=utf-8,' +
            header.join(',') +
            '\n' +
            csvData.map(row => Object.values(row).join(',')).join('\n');

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'user_roles.csv');
        document.body.appendChild(link);
        link.click();
    };

    const prepareAndExportData = () => {
        const opt = {
            margin: 10,
            filename: 'filtered_data.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        };

        // Create a hidden div to generate PDF content
        const container = document.createElement('div');

        // Create and style the table
        const table = document.createElement('table');
        table.style.borderCollapse = 'collapse';
        table.style.width = '100%';
        table.style.border = '1px solid #000';

        // Create table header row
        const headerRow = document.createElement('tr');

        // Column headers
        const headers = ['Role Name', 'Status']; // Replace with your column headers

        headers.forEach(headerText => {
            const th = document.createElement('th');
            th.style.border = '1px solid #000';
            th.style.padding = '8px';
            th.textContent = headerText;
            headerRow.appendChild(th);
        });

        // Append the header row to the table
        table.appendChild(headerRow);

        // Loop through filteredData to create table rows and cells
        filteredData.forEach(row => {
            const tr = document.createElement('tr');

            const roleNameCell = document.createElement('td');
            roleNameCell.style.border = '1px solid #000';
            roleNameCell.style.padding = '8px';
            roleNameCell.textContent = row.role_name;

            const statusCell = document.createElement('td');
            statusCell.style.border = '1px solid #000';
            statusCell.style.padding = '8px';
            statusCell.textContent = row.status;

            // Append cells to the row
            tr.appendChild(roleNameCell);
            tr.appendChild(statusCell);

            // Append the row to the table
            table.appendChild(tr);
        });

        // Append the table to the container
        container.appendChild(table);

        // Generate PDF from the container content
        html2pdf().from(container).set(opt).save();
    };

    const copyToClipboard = () => {
        const dataToCopy = JSON.stringify(filteredData); // Adjust data as needed
        navigator.clipboard.writeText(dataToCopy).then(() => {
            setCopied(true);
            setTimeout(() => {
                setCopied(false);
            }, 800); // Reset 'copied' state after 3 seconds
        });
    };

    const prepareDataForExcel = () => {
        return filteredData.map((row) => ({
            'Role Name': row.role_name,
            Status: row.status,
            // Add other fields as required
        }));
    };

    const downloadExcel = () => {
        const data = prepareDataForExcel();
        const header = Object.keys(data[0]);
        const csvContent =
            header.join(',') +
            '\n' +
            data.map((row) => Object.values(row).join(',')).join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'filtered_data.csv');
        document.body.appendChild(link);
        link.click();

        // Clean up the URL and remove the temporary link
        window.URL.revokeObjectURL(url);
        document.body.removeChild(link);
    };

    const handlePrint = () => {
        const printWindow = window.open('', '_blank');
        if (printWindow) {
            printWindow.document.write('<html><head><title>User Role Data</title></head><body>');
            printWindow.document.write('<style>@media print { body { font-family: Arial, sans-serif; }}</style>');
            printWindow.document.write('<table border="1" style="border-collapse: collapse; width: 100%;">');
            printWindow.document.write('<thead><tr><th>Role Name</th><th>Status</th></tr></thead>');
            printWindow.document.write('<tbody>');

            filteredData.forEach((item) => {
                printWindow.document.write(`<tr><td>${item.role_name}</td><td>${item.status}</td></tr>`);
                // Add other fields as needed
            });

            printWindow.document.write('</tbody></table></body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
    };

    return(
        <React.Fragment>
            <div className="d-flex justify-content-between">
                <CopyToClipboard text={JSON.stringify(filteredData)}>
                    <Button
                        style={{ marginRight: '10px' }}
                        type="button"
                        className="btn btn-primary text-sm text-md-lg"
                        onClick={copyToClipboard}>
                        Copy
                    </Button>
                </CopyToClipboard>
                <Button
                    type="button"
                    className="btn btn-primary"
                    style={{ marginRight: '10px' }}
                    onClick={exportToCSV}
                >
                    CSV
                </Button>
                <Button
                    type="button"
                    className="btn btn-primary"
                    onClick={downloadExcel}
                    style={{ marginRight: '10px' }}
                >
                    Excel
                </Button>
                <Button
                    type="button"
                    className="btn btn-primary"
                    style={{ marginRight: '10px' }}
                    onClick={prepareAndExportData}
                >
                    PDF
                </Button>
                {copied && <AlertModal/>}
                <Button
                    type="button"
                    className="btn btn-primary"
                    onClick={handlePrint}
                >
                    Print
                </Button>
            </div>
        </React.Fragment>
    )
}

export default DataExport
