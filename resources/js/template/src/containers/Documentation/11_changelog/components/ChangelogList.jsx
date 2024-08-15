import React, { Fragment } from 'react';
import {
 Card, CardSubhead, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';
import { Link } from 'react-router-dom';
import { DocumentationChangelog } from '../../DocumentationElements';

import data from './changelog_data.json';

const renderChangesList = (changes) => {
  if (!changes) return null;

  return (
    <ul>
      {changes.map(change => (
        <Fragment key={change.name}>
          <li>{change.path ? <Link to={change.path}>{change.name}</Link> : change.name}</li>
          {renderChangesList(change.changes)}
        </Fragment>
      ))}
    </ul>
  );
};

const ResourcesLinks = () => (
  <Card height="auto">
    <DocumentationChangelog>
      {data.map(version => (
        <Fragment key={version.version}>
          <CardTitleWrap>
            <CardTitle>v{version.version}</CardTitle>
            <CardSubhead>{version.date}</CardSubhead>
          </CardTitleWrap>
          {renderChangesList(version.changes)}
        </Fragment>
      ))}
    </DocumentationChangelog>
  </Card>
);

export default ResourcesLinks;
