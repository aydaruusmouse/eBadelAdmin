import React from 'react';
import {
 Card, CardBody, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';
import styled from 'styled-components';
import CodeHighlither from '@/shared/components/CodeHighlither';

const structureImage = `${process.env.PUBLIC_URL}/img/documentation/folder_structure.jpg`;
const titleImage = `${process.env.PUBLIC_URL}/img/documentation/site_title.jpg`;
const metaImage = `${process.env.PUBLIC_URL}/img/documentation/site_meta.jpg`;
const Settings = () => (
  <Card height="auto">
    <CardBody>
      <CardTitleWrap>
        <CardTitle>Change Site Title, Favicon and meta information</CardTitle>
      </CardTitleWrap>
      <p>It is doesn&apos;t matter which seed you choose to start building your app. Just because we based those on
        react.js we have <b>public</b> folder and some default structure in here.
      </p>
      <Image src={structureImage} alt="Folder structure image" />
      <p>So first steps that you need to do is:</p>
      <ol>
        <li>Replace <b>favicon.ico</b> and <b>fav.ic</b> with your own favicon image.</li>
        <li>
          Then go to <b>manifest.json</b> file and change it&apos;s data on your own.
          <br />
          <a href="https://developer.mozilla.org/en-US/docs/Web/Manifest" target="_blank" rel="noreferrer">
            (More about manifest.json)
          </a>
        </li>
        <CodeHighlither>
          {`{
  "short_name": "AP",
  "name": "Awesome Project",
  "icons": [
    {
      "src": "fav.ico",
      "sizes": "64x64 32x32 24x24 16x16",
      "type": "image/x-icon"
    }
  ],
  "start_url": ".",
  "display": "standalone",
  "theme_color": "#4ce1b6",
  "background_color": "#ffffff"
}`}
        </CodeHighlither>
        <li>Change application title.</li>
        <Image src={titleImage} alt="Site title change place" />
        <li>
          Add meta information about your site.
          <br />
          For example:
          <CodeHighlither>
            {'<meta name="description" content="Just a few words about your awesome app">'}
          </CodeHighlither>
        </li>
        <Image src={metaImage} alt="Site meta data change place" />
        <li>Change logo image.
          <br />
          Go to <b>utils/palette.js</b> find <b>logoImg</b> variable and change path to your logo image. But don&apos;t
          forgot to put image to <b>public/img/</b> folder
        </li>
        <CodeHighlither>
          {`// @utils/palette.js
export const logoImg = theme('mode', {
  light: \`url(\${process.env.PUBLIC_URL}/img/path/to/your/logo/logo_light.svg)\`,
  dark: \`url(\${process.env.PUBLIC_URL}/img/path/to/your/logo/logo_dark.svg)\`,
});`}
        </CodeHighlither>
        <li>
          <h4>Congrats! We ready to start building your App!</h4>
        </li>
      </ol>
    </CardBody>
  </Card>
);

export default Settings;

// region STYLES

const Image = styled.img`
  margin: 10px 0;
`;

// endregion
