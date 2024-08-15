import React from 'react';
import { Col, Row } from 'react-bootstrap';
import {
 Card, CardBody, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';
import styled from 'styled-components';
import CodeHighlither from '@/shared/components/CodeHighlither';
import { DocumentationChangelog, DocumentationMain, DocumentContainer } from '../DocumentationElements';
import Navigation from '../navigation/Navigation';
import NavigationBottom from '../navigation/NavigationBottom';

const Changelog = () => (
  <DocumentContainer>
    <Row>
      <Col md={12}>
        <h3 className="page-title">Documentation / FAQ Troubleshooting </h3>
      </Col>
    </Row>
    <DocumentationMain>
      <Col md={12} lg={3} xl={3} sm={12} xs={12}>
        <Navigation active="faq" />
      </Col>
      <Col md={12} lg={9} xl={9} sm={12} xs={12}>
        <Card height="auto">
          <DocumentationChangelog>
            <p>Please be careful when you follow the instruction.</p>
            <br />
            <p>
              The most of errors can appear during the installation of a libraries,
              launching a development version or creating a production version.
            </p>
            <br />
            <p>
              If you have an error like &quot;Error: Cannot find module &apos;module_name&apos;&quot; you need to
              check the stage with the installation of a libraries. This error means that the module is not installed.
            </p>
          </DocumentationChangelog>
        </Card>
        <Card height="auto">
          <CardBody>
            <CardTitleWrap>
              <CardTitle>FAQ</CardTitle>

              <List>
                <li>
                  How can I add some image to my component?
                  <ol>
                    <li>You can do it as easy as pie :) Just following this steps:
                      <CodeHighlither>
                        {`// inside your component file get image path
const yourImageVariable = \`\${process.env.PUBLIC_URL}/img/path/to/your/image/image.jpg\`;
// \${process.env.PUBLIC_URL} - this is the path to the public folder

// then inside your component use an img tag like this:
<img src={yourImageVariable} alt="something about image" />
`}
                      </CodeHighlither>
                    </li>
                  </ol>
                </li>
                <li>
                  How can I change path to page?
                  <ol>
                    <li>So, at the start we have two pages. To change path to page you need change path
                      in <b>@containers/App/Router</b>.
                      <br />
                      In this case we have route &quot;/pages/one&quot; and you can change it to any path you want. But
                      don&apos;t forget about changing link in sidebar or another place when you create link to page
                      <CodeHighlither>
                        {`// @containers/App/Router
const Pages = () => (
  <Switch>
    <Route path="/pages/one" component={ExamplePageOne} />
  </Switch>
);
`}
                      </CodeHighlither>
                    </li>
                  </ol>
                </li>
              </List>
            </CardTitleWrap>
          </CardBody>
        </Card>
      </Col>
    </DocumentationMain>

    <NavigationBottom prevLink="/documentation/changelog" prevTitle="Changelog" />
  </DocumentContainer>
);

export default Changelog;

// region STYLES

const List = styled.ol`
  li {
    text-transform: none;
  }
`;

// endregion
