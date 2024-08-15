import { Col, Container, Row } from 'react-bootstrap';
import React from 'react';
import { useTranslation } from 'react-i18next';
import { useSelector } from 'react-redux';
import Coins from './components/Coins';
import WalletInfo from './components/WalletInfo';
import TransactionsTable from './components/TransactionsTable';
import NFT from './components/NFT';


const Wallet = () => {
  const { t } = useTranslation('common');
  const rtl = useSelector(state => state.rtl);

  return (
    <Container>
      <Row>
        <Col md={12}>
          <h3 className="page-title">
            {t('wallet.page_title')}
          </h3>
        </Col>
      </Row>
      <Row>
        <WalletInfo dir={rtl.direction} />
        <Coins dir={rtl.direction} />
        <TransactionsTable dir={rtl.direction} />
        <NFT />
      </Row>
    </Container>
  );
};

export default Wallet;
