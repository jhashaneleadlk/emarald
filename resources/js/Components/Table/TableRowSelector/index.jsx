import React, {Fragment, useState} from "react";

const TableRowSelector = ({initialValue, OnTableRowCount}) => {
    const [pageSize, setPageSize] = useState(initialValue);
    const handlePageSizeChange = (e) => {
        const newSize = parseInt(e.target.value);
        setPageSize(newSize);
        OnTableRowCount(newSize)
    };

    return(
        <Fragment>
            <select
                className="form-select"
                value={pageSize}
                onChange={handlePageSizeChange}
            >
                {[10, 20, 30, 40, 50].map((size) => (
                    <option key={size} value={size}>
                        Show {size} rows
                    </option>
                ))}
            </select>
        </Fragment>
    )
}

export default TableRowSelector
