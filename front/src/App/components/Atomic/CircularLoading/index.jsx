import React from 'react';
import Spinner from 'react-bootstrap/Spinner';
import './style.css';

const CircularLoading = () => {
    return (
        <div className={'center-item'}>
            <Spinner animation="border" role="status" variant="primary" />
        </div>
    );
}

export default CircularLoading;