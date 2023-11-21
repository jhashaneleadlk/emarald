import React from "react";
import { Link } from "react-router-dom";

import SidebarContent from "./SidebarContent";
import logo from "../../../images/logo.svg";
import logoIcon from "../../../images/logo_Icon.svg";

const Sidebar = () => {

  return (
    <React.Fragment>
      <div className="vertical-menu">
        <div className="navbar-brand-box">
          <Link to="/" className="logo logo-dark">
            <span className="logo-sm">
              <img src={logoIcon} alt="" height="22" />
            </span>
            <span className="logo-lg">
              <img src={logo} alt="" height="45" />
            </span>
          </Link>
        </div>
        <div data-simplebar className="h-100">
          <SidebarContent />
        </div>
        <div className="sidebar-background"></div>
      </div>
    </React.Fragment>
  );
};

export default Sidebar
