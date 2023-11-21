import Breadcrumbs from "../../../../components/Common/Breadcrumb.jsx";
import React, { useMemo, useState } from "react";
import TableContainer from "../../../../components/Common/TableContainer.jsx";
import { Status } from "@/helpers/Table/UserStatusBadgeHandler.jsx";
import { Link } from "react-router-dom";
import { Col, Row} from "reactstrap";
import DataExport from "@/components/DataExport/DataExport.jsx";

import {sampleData} from "./DummuyUserRoleData.js"
import TableRowSelector from "@/components/Table/TableRowSelector/index.jsx";
import TableControllers from "@/pages/Admin/SystemUser/SystemUserRolePage/TableControllers.jsx";
const SystemUserRolePage = () => {
    // Meta title
    document.title = "Emarald Care | User Roles";

    const userRoleData = sampleData

    const [filteredData, setFilteredData] = useState(userRoleData);
    const [pageSize, setPageSize] = useState(10);

    const handlePageSizeChange = (value) => {
        setPageSize(value);
    };

    const columns = useMemo(
        () => [
            {
                Header: 'Role Name',
                accessor: 'role_name',
                Cell: ({ value }) => {
                    return value
                },
            },
            {
                Header: 'Status',
                accessor: 'status',
                Cell: ({ value }) => {
                    return <Status value={value} />;
                },
            },
            {
                Header: 'Action',
                accessor: 'action',
                disableFilters: true,
                Cell: (cellProps) => {
                    return (
                        <ul className="list-unstyled hstack gap-1 mb-0">
                            <li>
                                <Link
                                    to="#"
                                    className="btn btn-sm btn-soft-info"
                                    onClick={() => {
                                        const userData = cellProps.row.original;
                                        handleUserEditClick(userData);
                                    }}
                                >
                                    <i className="mdi mdi-pencil-outline" id="edittooltip" />
                                </Link>
                            </li>
                            <li>
                                <Link
                                    to="#"
                                    className="btn btn-sm btn-soft-danger"
                                    onClick={() => {
                                        const userData = cellProps.row.original;
                                        handleUserEditClick(userData);
                                    }}
                                >
                                    <i className="mdi mdi-delete-outline" id="deletetooltip" />
                                </Link>
                            </li>
                        </ul>
                    );
                },
            },
        ],
        []
    );

    // Function to handle user edit click
    const handleUserEditClick = () => {
        console.log(userRoleData)
    }

    return (
        <React.Fragment>
            <div className="page-content">
                <div className="container-fluid">
                    <Breadcrumbs title="User" breadcrumbItem="User Roles" />
                    <Row>
                        <Col className="col-12 col-xxl-5">
                           <Row>
                               <Col className="col-12 col-md-6 col-xxl-4 mb-3">
                                   <TableRowSelector initialValue={10} OnTableRowCount={(value) => handlePageSizeChange(value)}/>
                               </Col>
                               <Col className="col-12 col-md-6 mb-3">
                                   <DataExport filteredData = {filteredData}/>
                               </Col>
                           </Row>
                        </Col>
                        <Col className="col-12 col-xxl-7">
                            <TableControllers userRoleData={sampleData} onFilteredData={(filteredData) => setFilteredData(filteredData)}/>
                        </Col>
                    </Row>
                    <TableContainer
                        columns={columns}
                        data={filteredData}
                        isGlobalFilter={true}
                        isAddOptions={true}
                        handleJobClicks={handleUserEditClick}
                        isJobListGlobalFilter={true}
                        isPageSelect={false}
                        customPageSize={pageSize}
                        reponsive={true}
                    />
                    {filteredData.length === 0 && (
                        <div className="text-center mt-3">No data found.</div>
                    )}
                </div>
            </div>
        </React.Fragment>
    )
}

export default SystemUserRolePage;
