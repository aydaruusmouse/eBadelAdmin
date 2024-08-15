import React from 'react';
import Carousel from '@/shared/components/carousel/CarouselSingle';
import styled from 'styled-components';
import { getShortCryptoAddress } from '@/utils/helpers';
import useMatchMedia from '@/shared/hooks/useMatchMedia';
import LinkAsIcon from '@/shared/components/wallet/components/LinkAsIcon';
import TransactionSideText from '@/shared/components/wallet/components/TransactionSideText';
import { NFTItems } from './NFTData';

const NftItemsCarousel = () => {
  const isMdBreakpoint = useMatchMedia(600);

  return (
    <Carousel>
      {NFTItems.map(item => (
        <div>
          <CarouselItem key={item.id}>
            <CarouseImageWrapper>
              <CarouseImage src={item.image} alt={item.name} />
            </CarouseImageWrapper>
            <CarouselContent>
              <CarouselTitle>{item.name}</CarouselTitle>
              <LinkWrapper className="subhead">
                <span>{isMdBreakpoint ? getShortCryptoAddress(item.nft_id) : item.nft_id}</span>
                <LinkAsIcon href="/" />
              </LinkWrapper>
              <DateWrapper className="subhead">
                <span>{item.date}</span>
                <TransactionSideText text={item.side} />
              </DateWrapper>

              <Divider />

              <Price>{item.price}</Price>
            </CarouselContent>
          </CarouselItem>
        </div>
      ))}
    </Carousel>
  );
};

export default NftItemsCarousel;

// region STYLES

const CarouselItem = styled('div')`
  padding: 0 40px;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  gap: 100px;
  
  @media(max-width: 1199px) {
    flex-direction: column;
    gap: 34px;
  }
  
  @media(max-width: 600px) {
    padding: 0;
    align-items: flex-start;
  }
`;

const CarouseImageWrapper = styled('div')`
  position: relative;
  max-width: 800px;
  width: 100%;
  height: 0;
  padding-bottom: 34%;

  @media(max-width: 1199px) {
    padding-bottom: 64%;
  }
`;

const CarouseImage = styled('img')`
  position: absolute;
  width: 100%;
  height: 100% !important;
  left: 0;
  top: 0;
  object-fit: contain;
  object-position: center;
`;

const CarouselContent = styled('div')`
  text-align: left;
  
  @media(max-width: 600px) {
    width: 100%;
  }
`;

const CarouselTitle = styled('h2')`
  margin-bottom: 20px;

  @media(max-width: 1199px) {
    margin-bottom: 16px;
    font-size: 18px;
  }

  @media(max-width: 600px) {
    font-size: 16px;
  }
`;

const TextFlexWrapper = styled('h3')`
  margin-bottom: 32px;
  display: flex;
  justify-content: flex-start;
  align-items: center;

  @media(max-width: 1199px) {
    margin-bottom: 16px;
    font-size: 14px;
    
    &.subhead {
      font-size: 14px;
    }
  }
`;

const Price = styled('h3')`
  @media(max-width: 1199px) {
    font-size: 14px;
  }
`;

const LinkWrapper = styled(TextFlexWrapper)`
  gap: 15px;
`;

const DateWrapper = styled(TextFlexWrapper)`
  gap: 24px;
`;

const Divider = styled('hr')`
  border-color: #3A3A40;
  opacity: 1;
  margin: 32px 0;

  @media(max-width: 1199px) {
    margin: 24px 0;
  }
`;

// endregion
