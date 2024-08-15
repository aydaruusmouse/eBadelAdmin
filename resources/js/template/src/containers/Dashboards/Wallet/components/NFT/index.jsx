import React from 'react';
import Panel from '@/shared/components/Panel';
import { useTranslation } from 'react-i18next';
import { BorderedBottomTabs } from '@/shared/components/Tabs';
import Tabs from './Tabs';

const NFT = () => {
  const { t } = useTranslation('common');

  return (
    <Panel md={12} title={t('wallet.nft_title')}>
      <BorderedBottomTabs>
        <Tabs />
      </BorderedBottomTabs>
    </Panel>
  );
};

export default NFT;
