import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { useSelector } from 'react-redux';
import { useTranslation } from 'react-i18next';
import styled from 'styled-components';
import { Legend, Pie, Tooltip } from 'recharts';
import Panel from '@/shared/components/Panel';
import getTooltipStyles from '@/shared/helpers';
import useMatchMedia from '@/shared/hooks/useMatchMedia';
import { colorAdditional, colorDarkText, scrollbarStyles } from '@/utils/palette';
import {
  Bullet,
  DashboardChartLegendTable,
  DashboardPieChartContainer,
  DashboardPieChartFlex,
} from '../../BasicDashboardComponents';

const data01 = [
  {
    id: 0, alias: 'GMT', name: 'Green Metaverse Token', value: 100, fill: '#4CE1B6', amount: '11', total: '153.00 USDT',
  },
  {
    id: 16, alias: 'CAKE', name: 'PancakeSwap', value: 60, fill: '#FA697D', amount: '0.009', total: '1499.00 USDT',
  },
  {
    id: 2, alias: 'USDT', name: 'Tether', value: 70, fill: '#70BBFD', amount: '6.83', total: '1263.00 USDT',
  },
  {
    id: 4, alias: 'USDC', name: 'USD Coin', value: 99, fill: '#F6DA6E', amount: '250', total: '278.00 USDT',
  },
  {
    id: 5, alias: 'FTC', name: 'Future Coin', value: 221, fill: '#7ED321', amount: '35', total: '53.82 USDT',
  },
  {
    id: 6, alias: 'POLS', name: 'Polkastarter', value: 374, fill: '#B635BA', amount: '20', total: '13.65 USDT',
  },
  {
    id: 7, alias: 'BNB', name: 'Binance Coin', value: 212, fill: '#F6816E', amount: '6.8', total: '9.81 USDT',
  },
  {
    id: 8, alias: 'AVAX', name: 'Avalanche', value: 321, fill: '#38C3D7', amount: '98.62', total: '3.25 USDT',
  },
  {
    id: 9, alias: 'ETH', name: 'Ethereum', value: 322, fill: '#F98330', amount: '98.6', total: '2.96 USDT',
  },
];

const RenderLegend = ({ payload }) => {
  const { t } = useTranslation('common');

  return (
    <DashboardChartLegendTable>
      <LegendCol>
        <LegendColTitle>{t('wallet.coin')}</LegendColTitle>
        <LegendColContent>
          {payload.map(entry => (
            <li key={entry.payload.id}>
              <Bullet color={entry.color} />
              {entry.payload.alias}{' '}
              <LegendSubtext>{entry.value}</LegendSubtext>
            </li>
          ))}
        </LegendColContent>
      </LegendCol>

      <LegendCol>
        <LegendColTitle>{t('wallet.amount')}</LegendColTitle>
        <LegendColContent>
          {payload.map(entry => (
            <li key={entry.payload.amount}>
              {entry.payload.amount}
            </li>
          ))}
        </LegendColContent>
      </LegendCol>

      <LegendCol>
        <LegendColTitle>{t('wallet.total')}</LegendColTitle>
        <LegendColContent>
          {payload.map(entry => (
            <li key={entry.payload.total}>
              {entry.payload.total}
            </li>
          ))}
        </LegendColContent>
      </LegendCol>
    </DashboardChartLegendTable>
  );
};

RenderLegend.propTypes = {
  payload: PropTypes.arrayOf(PropTypes.shape({
    color: PropTypes.string,
    value: PropTypes.string,
    amount: PropTypes.string,
    total: PropTypes.string,
    alias: PropTypes.string,
  })).isRequired,
};

const Coins = ({ dir }) => {
  const { t } = useTranslation('common');
  const [coordinates, setCoordinates] = useState({ x: 0, y: 0 });

  const themeName = useSelector(state => state.theme.className);

  const isMdBreakpoint = useMatchMedia(1199);

  const onMouseMove = (e) => {
    if (e.tooltipPosition) {
      setCoordinates({ x: dir === 'ltr' ? e.tooltipPosition.x : e.tooltipPosition.x / 10, y: e.tooltipPosition.y });
    }
  };

  return (
    <Panel lg={12} xxl={9} title={t('wallet.coins')}>
      <div dir="ltr">
        <DashboardCoinsChartContainer width="100%">
          <DashboardPieChartFlex>
            <Tooltip position={coordinates} {...getTooltipStyles(themeName)} />
            <Pie
              data={data01}
              dataKey="value"
              cy={180}
              innerRadius={110}
              outerRadius={140}
              label
              onMouseMove={onMouseMove}
            />

            <Legend
              layout="vertical"
              verticalAlign={isMdBreakpoint ? 'bottom' : 'top'}
              content={RenderLegend}
              align={isMdBreakpoint ? 'center' : 'right'}
            />
          </DashboardPieChartFlex>
        </DashboardCoinsChartContainer>
      </div>
    </Panel>
  );
};

Coins.propTypes = {
  dir: PropTypes.string.isRequired,
};

export default Coins;

// region

const DashboardCoinsChartContainer = styled(DashboardPieChartContainer)`
  min-height: 360px !important;
  height: 100% !important;
  
  svg {
    min-height: 360px;
    position: absolute;
    left: 0;
    top: 0;
    
    @media(max-width: 1640px) {
      max-width: 90%;
    }
    
    @media(max-width: 1199px) {
      max-width: 100%;
    }
    
    @media(max-width: 768px) {
      height: 80% !important;
    }
    
    @media(max-width: 400px) {
      height: 60% !important;
    }

    .recharts-pie {
      transform: translateX(-60px);
      
      @media(max-width: 1919px) {
        transform: translateX(0);
      }
    }
  }
  
  .recharts-legend-wrapper {
    position: relative !important;
    max-width: 55%;
    width: 100% !important;
    z-index: 5;

    @media(max-width: 1919px) {
      max-width: 50%;
    }
    @media(max-width: 1199px) {
      max-width: 100%;
    }
    @media(max-width: 768px) {
      overflow-x: auto;
      
      ${scrollbarStyles};
    }
  }
`;

const LegendCol = styled('div')`
  flex-shrink: 2;
  flex-grow: 0;

  :first-child {
    flex-shrink: 0;
    flex-basis: 195px;
  }

  :last-child {
    flex-basis: 10%;
    flex-grow: 1;
  }
`;

const LegendColTitle = styled('div')`
  margin-bottom: 20px;
  font-size: 12px;
  font-weight: 700;
  line-height: 1.1;
  color: ${colorDarkText};
`;

const LegendColContent = styled('ul')`
  padding: 0;
  list-style: none;
  color: ${colorDarkText};

  li {
    margin-top: 15px;
  }
`;

const LegendSubtext = styled('span')`
  color: ${colorAdditional};
`;

// endregion
