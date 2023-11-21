import React, {Fragment, useEffect, useState} from "react";
import PropTypes from "prop-types";
import {
    useTable,
    useGlobalFilter,
    useSortBy,
    useFilters,
    useExpanded,
    usePagination,
} from "react-table";
import { Table } from "reactstrap";
import { Link } from "react-router-dom";

const TableContainer = ({
                            columns,
                            data,
                            customPageSize,
                            className,

                        }) => {
    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        page,
        prepareRow,
        canPreviousPage,
        canNextPage,
        pageOptions,
        gotoPage,
        nextPage,
        previousPage,
        setPageSize,
        state: { pageIndex, pageSize },
    } = useTable(
        {
            columns,
            data,
            initialState: {
                pageIndex: 0,
                pageSize:  customPageSize || 20,
                sortBy: [
                    {
                        desc: true,
                    },
                ],
            },
            usePagination
        },
        useGlobalFilter,
        useFilters,
        useSortBy,
        useExpanded,
        usePagination
    );

    // Update pageSize when customPageSize changes
    useEffect(() => {
        setPageSize(customPageSize || 20);
    }, [customPageSize, setPageSize]);

    const generateSortingIndicator = (column) => {
        return column.isSorted ? (
            column.isSortedDesc ? (
                <span className="ms-2">&#8645;</span>
            ) : (
                <span className="ms-2">&#8645;</span>
            )
        ) : (
            ""
        );
    };

    return (
        <Fragment>
            <div className="table-responsive react-table">
                <Table responsive bordered hover {...getTableProps()} className={className}>
                    <thead className="table-light table-nowrap">
                    {headerGroups.map(headerGroup => (
                        <tr key={headerGroup.id} {...headerGroup.getHeaderGroupProps()}>
                            {headerGroup.headers.map(column => (
                                <th key={column.id}>
                                    <div {...column.getSortByToggleProps()}>
                                        {column.render("Header")}
                                        {generateSortingIndicator(column)}
                                    </div>
                                </th>
                            ))}
                        </tr>
                    ))}
                    </thead>

                    <tbody {...getTableBodyProps()}>
                    {page.map(row => {
                        prepareRow(row);
                        return (
                            <Fragment key={row.getRowProps().key}>
                                <tr>
                                    {row.cells.map(cell => {
                                        return (
                                            <td key={cell.id} {...cell.getCellProps()}>
                                                {cell.render("Cell")}
                                            </td>
                                        );
                                    })}
                                </tr>
                            </Fragment>
                        );
                    })}
                    </tbody>
                </Table>
            </div>

            <ul className="pagination pagination-rounded justify-content-end mb-2">
                <li className="page-item disabled">
                    <Link className={!canPreviousPage ? "page-link disabled" : " page-link"} onClick={previousPage} to="#" aria-label="Previous">
                        <i className="mdi mdi-chevron-left"></i>
                    </Link>
                </li>
                {pageOptions.map((item, key) => (
                    <React.Fragment key={key}>
                        <li className={pageIndex === item ? "active" : ""}>
                            <Link to="#" className="page-link" onClick={() => gotoPage(item)}>{item + 1}</Link>
                        </li>
                    </React.Fragment>
                ))}
                <li className={!canNextPage ? "page-item disabled" : "page-item"} aria-label="Next">
                    <Link to="#" className="page-link" onClick={nextPage}>
                        <i className="mdi mdi-chevron-right"></i>
                    </Link>
                </li>
            </ul>
        </Fragment>
    );
};

TableContainer.propTypes = {
    customPageSize: PropTypes.number,
};

export default TableContainer;
