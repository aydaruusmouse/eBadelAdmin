import React from 'react';
import { Nav, Tab } from 'react-bootstrap';
import { NavItem, NavLink, TabsWrap } from '@/shared/components/Tabs';
import { useTranslation } from 'react-i18next';
import NftItems from './NFTItems';
import NftActivity from './NFTActivity';
import { PanelTabs } from '../../styled';

const Tabs = () => {
  const { t } = useTranslation('common');

  return (
    <PanelTabs>
      <Tab.Container defaultActiveKey="1">
        <TabsWrap>
          <Nav className="nav-tabs">
            <NavItem>
              <NavLink eventKey="1">
                {t('wallet.nft_items')}
              </NavLink>
            </NavItem>
            <NavItem>
              <NavLink eventKey="2">
                {t('wallet.nft_activity')}
              </NavLink>
            </NavItem>
          </Nav>
          <Tab.Content>
            <Tab.Pane eventKey="1">
              <NftItems />
            </Tab.Pane>
            <Tab.Pane eventKey="2">
              <NftActivity />
            </Tab.Pane>
          </Tab.Content>
        </TabsWrap>
      </Tab.Container>
    </PanelTabs>
  );
};

export default Tabs;
