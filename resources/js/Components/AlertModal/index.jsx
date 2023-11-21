import React from "react"
import PropTypes from "prop-types"
import {
    Button,
    Modal,
    ModalBody,
    ModalHeader,
    Row,
    Col
} from "reactstrap"

import check_icon from "../../../images/icons/check_mark.svg"
import logo from "../../../images/logo.svg";

const AlertModal = props => {
    const { isOpen, toggle } = props

    return (
        <Modal
            isOpen={true}
            role="dialog"
            autoFocus={true}
            centered={true}
            tabIndex="-1"
            toggle={toggle}
            style={{ width: '250px' }}
        >
            <div>
                <ModalBody className="text-center">
                    <div className="d-flex justify-content-center align-items-center">
                        <div className="mx-1">
                            <img src={check_icon} alt="" height="35" />
                        </div>
                        <span className="fs-5 ml-2">Copied to Clipboard</span>
                    </div>
                </ModalBody>
            </div>
        </Modal>
    )
}

AlertModal.propTypes = {
    toggle: PropTypes.func,
    isOpen: PropTypes.bool,
}

export default AlertModal
