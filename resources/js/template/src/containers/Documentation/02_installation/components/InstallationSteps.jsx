import React from 'react';
import styled from 'styled-components';
import { Link } from 'react-router-dom';
import {
 Card, CardBody, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';

const nodeImage = `${process.env.PUBLIC_URL}/img/documentation/nodejs.jpg`;
const yarnImage = `${process.env.PUBLIC_URL}/img/documentation/yarn.jpg`;

const InstallationSteps = () => (
  <Card height="auto">
    <CardBody>
      <CardTitleWrap>
        <CardTitle>Installation</CardTitle>
      </CardTitleWrap>
      <p>
        EasyDEV is based on create-react-app and has its README.md which you can
        find very useful.
      </p>
      <p>To get started follow this steps:</p>
      <ol>
        <li>
          First of all you need to go to{' '}
          <a href="https://nodejs.org/en/download" target="_blank" rel="noreferrer">Nodejs.org</a>{' '}
          and download and install Node.js LTS version according to your OS.
          <Image src={nodeImage} alt="nodejs download page" />

          <ol>
            <li>
              If you using Linux we recommended to install Node.js via{' '}
              <a href="https://github.com/nvm-sh/nvm" target="_blank" rel="noreferrer">nvm</a>.
            </li>
          </ol>

        </li>
        <li>
          Then install Docker using one of those links depends on your OS:
          <ol>
            <li>
              <a href="https://docs.docker.com/desktop/install/windows-install/" target="_blank" rel="noreferrer">
                Windows.
              </a>
            </li>
            <li>
              <a href="https://docs.docker.com/desktop/install/mac-install/" target="_blank" rel="noreferrer">
                MacOS.
              </a>
            </li>
            <li>
              <a href="https://docs.docker.com/engine/install/ubuntu/" target="_blank" rel="noreferrer">
                Linux, Ubuntu
              </a>{' '}
              or{' '}
              <a
                href="https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04"
                target="_blank"
                rel="noreferrer"
              >
                this link for Linux, Ubuntu.
              </a>
            </li>
          </ol>
        </li>
        <li>
          Install{' '}
          <a
            href="https://classic.yarnpkg.com/lang/en/docs/install/#windows-stable"
            target="_blank"
            rel="noreferrer"
          >
            Yarn
          </a>{' '}
          if you prefer it to the npm.
          <Image src={yarnImage} alt="yarn installation page" />
        </li>
        <li>Download and open project.</li>
        <li>
          First you need to do to start coding is very easy ;)
          <br />
          You need to install packages by using one of these command: <b>npm i</b>,{' '}
          <b>npm install</b> or{' '}
          <b>yarn install</b>.
        </li>
        <li>
          Here are two ways how the project can be started:
          <ol>
            <li>
              <b>npm start</b> or <b>yarn start</b> (running on port 3000). But
              the proxy server won&apos;t be started and CoinCap and CoinMarketCap
              API&apos;s won&apos;t work. So{' '}
              <Link to="/documentation/finance_dashboard">
                Finance dashboard
              </Link>{' '}
              won&apos;t display any data.
            </li>
            <li>
              <b>docker-compose up</b> (running on port 3000). In this case,
              the proxy server will be started and CoinCap and CoinMarketCap API&apos;s
              will work. So{' '}
              <Link to="/documentation/finance_dashboard">
                Finance dashboard
              </Link>{' '}
              will display the data.
              <ol>
                <li>
                  Here you can read about{' '}
                  <a href="https://docs.docker.com/get-started/08_using_compose/" target="_blank" rel="noreferrer">
                    docker-compose
                  </a>.
                </li>
              </ol>
            </li>
          </ol>
        </li>
        <li>
          Make necessary changes.
          <br />
          You can read more about it in the following paragraphs.
        </li>
        <li>
          Build app for production: <b>npm run build</b> or <b>yarn build</b>.
        </li>
        <li>
          You are awesome! The last thing to do is publishing your app on the Internet.
          <ol>
            <li>
              If you don&apos;t know how to do it, you can ask for help on our{' '}
              <a
                target="_blank"
                rel="noopener noreferrer"
                href="https://discord.gg/8aJkBc8gFN"
              >
                Discord server
              </a>.
            </li>
          </ol>
        </li>
      </ol>
    </CardBody>
  </Card>
);

export default InstallationSteps;

// region STYLES

const Image = styled.img`
  margin: 10px 0;
`;

// endregion
