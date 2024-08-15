import React from 'react';
import PropTypes from 'prop-types';

const TransactionSideText = ({ text }) => (
  <span className={text.toLowerCase() === 'in' ? 'green-text' : 'red-text'}>
    {text}
  </span>
);

TransactionSideText.propTypes = {
  text: PropTypes.oneOf(['In', 'Out']).isRequired,
};

export default TransactionSideText;
