import PropTypes from "prop-types";
import React from "react";
import {
  Container
} from "reactstrap";

//Import Breadcrumb
import Breadcrumbs from "../../../components/Common/Breadcrumb.jsx";

//i18n
import { withTranslation } from "react-i18next";

const Dashboard = props => {

  //meta title
  document.title = "Dashboard | Skote React + Laravel 10 Admin And Dashboard Template";

  return (
    <React.Fragment>
      <div className="page-content">
        <Container fluid>
            <button type="button" className="btn btn-primary">Primary</button>
          {/* Render Breadcrumb */}
          <Breadcrumbs
            title={props.t("Dashboards")}
            breadcrumbItem={props.t("Dashboard")}
          />
        </Container>
      </div>
    </React.Fragment>
  );
};

Dashboard.propTypes = {
  t: PropTypes.any,
  chartsData: PropTypes.any,
  onGetChartsData: PropTypes.func,
};

export default withTranslation()(Dashboard);
