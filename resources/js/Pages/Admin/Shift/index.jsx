import React from "react";
import {Container} from "reactstrap";

import Breadcrumbs from "../../../components/Common/Breadcrumb.jsx";

const Shift = (props) => {

    //meta title
    document.title = "Emarald Care";

    return(
        <React.Fragment>
            <div className="page-content">
                <Container fluid>
                    {/* Render Breadcrumb */}
                    <Breadcrumbs
                        title={"Dashboards"}
                        breadcrumbItem={"Shift"}
                    />
                </Container>
            </div>
        </React.Fragment>
    )
}

export default Shift
