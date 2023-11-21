import React, { useEffect, useState } from 'react';
import { useLocation } from 'react-router-dom';
import withRouter from '../Common/withRouter';
import PropTypes from "prop-types";

//components
import Navbar from "./Navbar";
import Header from "./Header";
import Footer from "./Footer";
import { createSelector } from 'reselect';

const Layout = (props) => {
  const pathName = useLocation();

  useEffect(() => {
    const title = pathName.pathname;
    let currentage = title.charAt(1).toUpperCase() + title.slice(2);

    document.title =
      currentage + " | Skote React + Laravel 10 Admin And Dashboard Template";
  }, [pathName.pathname]);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, []);

  const [isMenuOpened, setIsMenuOpened] = useState(false);
  const openMenu = () => {
    setIsMenuOpened(!isMenuOpened);
  };

  return (
    <React.Fragment>
      {/*<div id="preloader">*/}
      {/*  <div id="status">*/}
      {/*    <div className="spinner-chase">*/}
      {/*      <div className="chase-dot" />*/}
      {/*      <div className="chase-dot" />*/}
      {/*      <div className="chase-dot" />*/}
      {/*      <div className="chase-dot" />*/}
      {/*      <div className="chase-dot" />*/}
      {/*      <div className="chase-dot" />*/}
      {/*    </div>*/}
      {/*  </div>*/}
      {/*</div>*/}

      {/*<div id="layout-wrapper">*/}
      {/*  <Header*/}
      {/*    theme={topbarTheme}*/}
      {/*    isMenuOpened={isMenuOpened}*/}
      {/*    openLeftMenuCallBack={openMenu}*/}
      {/*  />*/}
      {/*  <Navbar menuOpen={isMenuOpened} />*/}
      {/*  <div className="main-content">{props.children}</div>*/}
      {/*  <Footer />*/}
      {/*</div>*/}
    </React.Fragment>
  );
};

export default withRouter(Layout);
