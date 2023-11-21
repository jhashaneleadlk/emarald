import React from "react";

const StatusFilter = ({ selectedStatus, onChange }) => {
    const handleFilterChange = (e) => {
        const selectedValue = e.target.value;
        onChange(selectedValue);
    };

    return (
        <div className="filter-dropdown">
            <select
                id="statusFilter"
                value={selectedStatus}
                onChange={handleFilterChange}
                className="form-control select2"
            >
                <option value="All">All</option>
                <option value="Active">Active</option>
                <option value="Deactivate">Deactivate</option>
            </select>
        </div>
    );
};

export default StatusFilter
