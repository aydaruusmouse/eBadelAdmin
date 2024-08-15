import React from 'react';
import styled from 'styled-components';
import PropTypes from 'prop-types';
import { linkImage } from './icons';

const LinkAsIcon = ({ href, description }) => (
  <a href={href}><IconImage src={linkImage} alt={description} /></a>
);

LinkAsIcon.propTypes = {
  href: PropTypes.string.isRequired,
  description: PropTypes.string,
};
LinkAsIcon.defaultProps = {
  description: 'go to',
};

export default LinkAsIcon;

// region STYLE
const IconImage = styled('img')`
  // TODO: because of slick-slider
  width: 13px !important;
  height: 13px !important;
  object-fit: contain;
  object-position: center;
`;
