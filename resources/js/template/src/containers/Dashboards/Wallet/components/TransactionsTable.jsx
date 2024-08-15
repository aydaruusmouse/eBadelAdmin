import React, { useState } from 'react';
import { Table } from '@/shared/components/TableElements';
import Badge from '@/shared/components/Badge';
import PropTypes from 'prop-types';
import { useTranslation } from 'react-i18next';
import Panel from '@/shared/components/Panel';
import Tooltip from '@/shared/components/Tooltip';
import ChevronDownIcon from 'mdi-react/ChevronDownIcon';
import styled from 'styled-components';
import {
 Dropdown, DropdownItem, DropdownMenu, DropdownToggle, 
} from '@/shared/components/Dropdown';
import LinkAsIcon from '@/shared/components/wallet/components/LinkAsIcon';
import TransactionSideText from '@/shared/components/wallet/components/TransactionSideText';
import { StyledNoWrapCell, TableRow } from '../styled';

const headerData = [
  { id: 1, title: 'Date' },
  { id: 2, title: 'From' },
  { id: 3, title: 'To' },
  { id: 4, title: 'Side' },
  { id: 5, title: 'Token' },
  { id: 6, title: 'Amount' },
  { id: 7, title: 'Total' },
  { id: 8, title: 'Status' },
  { id: 9, title: '' },
];
const rowsData = [{
  id: 1,
  date: '2022-05-09 16:54',
  from: '0x6d3...a2d',
  to: '@0xbn9...c4k',
  side: 'Out',
  token: 'LUNA',
  amount: '11',
  total: '701.8 USDT',
  status: 'Filled',
  badge_resp: 'primary',
}, {
  id: 2,
  date: '2022-05-09 16:54',
  from: '0x6d3...a2d',
  to: '@0xbn9...c4k',
  side: 'Out',
  token: 'LUNA',
  amount: '11',
  total: '701.8 USDT',
  status: 'Canceled',
  badge_resp: 'warning',
}, {
  id: 3,
  date: '2022-05-09 16:54',
  from: '0x6d3...a2d',
  to: '@0xbn9...c4k',
  side: 'Out',
  token: 'LUNA',
  amount: '11',
  total: '701.8 USDT',
  status: 'Canceled',
  badge_resp: 'danger',
}];

const TransactionsTable = ({ dir }) => {
  const { t } = useTranslation('common');
  const [viewedDelay, setViewedDelay] = useState('24 hours');

  const transactionsDelay = (
    <Dropdown>
      <TransactionsToggleButton variant="outline-secondary">
        <span>{viewedDelay} <ChevronDownIcon /></span>
      </TransactionsToggleButton>
      <DropdownMenu>
        <DropdownItem onClick={() => setViewedDelay('24 hours')}>24 hours</DropdownItem>
        <DropdownItem onClick={() => setViewedDelay('1 week')}>1 week</DropdownItem>
      </DropdownMenu>
    </Dropdown>
  );

  return (
    <Panel md={12} title={t('wallet.transactions')} extraPanelButton={transactionsDelay}>
      <div dir="ltr">
        <Table bordered responsive>
          <thead>
            <tr>
              {headerData.map(item => (
                <th key={item.id}>{item.title}</th>
            ))}
            </tr>
          </thead>
          <tbody>
            {rowsData.map(item => (
              <TableRow key={item.id}>
                <StyledNoWrapCell>{item.date}</StyledNoWrapCell>
                <td>{item.from}</td>
                <td>{item.to}</td>
                <td><TransactionSideText text={item.side} /></td>
                <td>{item.token}</td>
                <td>{item.amount}</td>
                <td>{item.total}</td>
                <td><Badge bg={item.badge_resp}>{item.status}</Badge></td>
                <td>
                  <Tooltip text={t('wallet.transactions_link')} dir={dir} placement="top">
                    <LinkAsIcon href="/" />
                  </Tooltip>
                </td>
              </TableRow>
          ))}
          </tbody>
        </Table>
      </div>
    </Panel>
  );
};

TransactionsTable.propTypes = {
  dir: PropTypes.string.isRequired,
};

export default TransactionsTable;

// region STYLES

const TransactionsToggleButton = styled(DropdownToggle)`
margin-bottom: 0;
`;


