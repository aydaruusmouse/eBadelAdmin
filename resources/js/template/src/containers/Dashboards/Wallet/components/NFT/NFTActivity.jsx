import React from 'react';
import { Table } from '@/shared/components/TableElements';
import LinkAsIcon from '@/shared/components/wallet/components/LinkAsIcon';
import TransactionSideText from '@/shared/components/wallet/components/TransactionSideText';
import { StyledNoWrapCell, TableRow } from '../../styled';
import { NFTItems } from './NFTData';

const headerData = [
  { id: 1, title: '#' },
  { id: 2, title: 'Date' },
  { id: 3, title: 'NFT ID' },
  { id: 4, title: 'Name' },
  { id: 5, title: 'Price' },
  { id: 6, title: 'Side' },
  { id: 9, title: '' },
];

const NftActivity = () => (
  <Table bordered responsive>
    <thead>
      <tr>
        {headerData.map(item => (
          <th key={item.id}>{item.title}</th>
      ))}
      </tr>
    </thead>
    <tbody>
      {NFTItems.map(item => (
        <TableRow key={item.id}>
          <td>{item.id}</td>
          <StyledNoWrapCell>{item.date}</StyledNoWrapCell>
          <td>{item.nft_id}</td>
          <td>{item.name}</td>
          <td>{item.price}</td>
          <td><TransactionSideText text={item.side} /></td>
          <td style={{ width: '20px' }}>
            <LinkAsIcon href="/" />
          </td>
        </TableRow>
    ))}
    </tbody>
  </Table>
);

export default NftActivity;
