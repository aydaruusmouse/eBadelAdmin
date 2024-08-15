import React from 'react';
import { useTranslation } from 'react-i18next';
import Panel from '@/shared/components/Panel';
import Tooltip from '@/shared/components/Tooltip';
import PropTypes from 'prop-types';
import { getShortCryptoAddress } from '@/utils/helpers';
import {
  WalletConnection,
  WalletInfoWrapper,
  WalletStatRowTitle,
  WalletStatRowValue,
  WalletStatRowWrapper,
} from '../styled';
import { SidebarLinkIcon } from '../../../Layout/components/sidebar/SidebarLink';

const WALLET_ADDRESS = '0xe9be55ffedb6c2a2f3f8eac31e60d7f122f799';

const WalletInfo = ({ dir }) => {
  const { t } = useTranslation('common');

  const onCopyWalletAddress = () => {
    navigator.clipboard.writeText(WALLET_ADDRESS);
  };

  const panelFooter = (
    <WalletConnection type="button">
      <span>{t('wallet.disconnect')}</span>
      <SidebarLinkIcon className="lnr lnr-exit" />
    </WalletConnection>
  );

  return (
    <Panel xs={12} lg={6} xxl={3} title={t('wallet.page_title')} panelFooter={panelFooter}>
      <WalletInfoWrapper>
        <WalletStatRowWrapper>
          <WalletStatRowTitle>{t('wallet.address')}</WalletStatRowTitle>
          <WalletStatRowValue variant="small">
            <span>{getShortCryptoAddress(WALLET_ADDRESS)}</span>
            <Tooltip text="Copy wallet address" dir={dir} placement="top">
              <SidebarLinkIcon className="lnr lnr-book" onClick={onCopyWalletAddress} />
            </Tooltip>
          </WalletStatRowValue>
        </WalletStatRowWrapper>

        <WalletStatRowWrapper>
          <WalletStatRowTitle>{t('wallet.balance')}</WalletStatRowTitle>
          <WalletStatRowValue>0.05 BTC</WalletStatRowValue>
        </WalletStatRowWrapper>

        <WalletStatRowWrapper>
          <WalletStatRowTitle>{t('wallet.estimated_value')}</WalletStatRowTitle>
          <WalletStatRowValue>1012.8 USDT</WalletStatRowValue>
        </WalletStatRowWrapper>
      </WalletInfoWrapper>
    </Panel>
  );
};

WalletInfo.propTypes = {
  dir: PropTypes.string.isRequired,
};

export default WalletInfo;
