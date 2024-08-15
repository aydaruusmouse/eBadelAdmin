import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { DocumentationMain, DocumentContainer } from '../DocumentationElements';
import Navigation from '../navigation/Navigation';
import NavigationBottom from '../navigation/NavigationBottom';
import Settings from './Components/Settings';

const BaseSettings = () => (
  <DocumentContainer>
    <Row>
      <Col md={12}>
        <h3 className="page-title">Documentation / Base site settings</h3>
      </Col>
    </Row>
    <DocumentationMain>
      <Col md={12} lg={3} xl={3} sm={12} xs={12}>
        <Navigation active="base_settings" />
      </Col>
      <Col md={12} lg={9} xl={9} sm={12} xs={12}>
        <Settings />
      </Col>
    </DocumentationMain>
    <NavigationBottom
      prevLink="/documentation/file_structure"
      prevTitle="File Structure"
      nextLink="/documentation/components"
      nextTitle="Components"
    />
  </DocumentContainer>
);

export default BaseSettings;
