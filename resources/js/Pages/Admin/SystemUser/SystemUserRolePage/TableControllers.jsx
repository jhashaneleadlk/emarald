import {Button, Col, Row} from "reactstrap";
import React, {useState} from "react";
import StatusFilter from "@/pages/Admin/SystemUser/SystemUserRolePage/StatusFilter.jsx";

const TableControllers = ({userRoleData, onFilteredData}) => {
    const [selectedStatus, setSelectedStatus] = useState('All');
    const [filteredData, setFilteredData] = useState(userRoleData);

    const handleFilterChange = (selectedValue) => {
        setSelectedStatus(selectedValue);
        const filtered = userRoleData.filter(item => {
            if (selectedValue === 'All') {
                return true;
            } else {
                return item.status === selectedValue;
            }
        });
        onFilteredData(filtered)
        setFilteredData(filtered);
    };
    const handleSearchChange = (e) => {
        const value = e.target.value || '';

        const filtered = userRoleData.filter(item =>
            Object.values(item).some(val =>
                val.toString().toLowerCase().includes(value.toLowerCase())
            )
        );

        const filteredByStatus = filtered.filter(item => {
            if (selectedStatus === 'All') {
                return true;
            } else {
                return item.status === selectedStatus;
            }
        });

        onFilteredData(filteredByStatus)
        setFilteredData(filteredByStatus);
    };

    return(
        <Row>
            <Col className="col-12 col-lg-4 col-xxl-6 mb-3">
                <div className="search-box me-xxl-2 d-inline-block w-100">
                    <div className="position-relative w-100">
                                <span id="search-bar-0-label" className="sr-only">
                                 Search this table
                            </span>
                        <input
                            onChange={handleSearchChange}
                            id="search-bar-0"
                            type="text"
                            placeholder={`${filteredData && filteredData.length && filteredData.length} records...`}
                            className="form-control rounded w-100"
                        />
                        <i className="bx bx-search-alt search-icon"></i>
                    </div>
                </div>
            </Col>
            <Col className="col-6 col-lg-4 col-xxl-3 mb-3">
                <div className="filter-section mr-2">
                    <StatusFilter onChange={(value) => handleFilterChange(value)} />
                </div>
            </Col>
            <Col className="col-6 col-lg-4 col-xxl-3 mb-3">
                <Button
                    type="button"
                    color="primary"
                    className="btn-rounded-md w-100"
                    // onClick={handleOrderClicks}
                >
                    <i className="mdi mdi-plus me-1" />
                    Add New Role
                </Button>
            </Col>
        </Row>
    )
}

export default TableControllers
