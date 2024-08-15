import React, { useState } from 'react';
import styled from 'styled-components';
import SimpleModal from '@/shared/components/Modal/SimpleModal';
import { NFTItemsWrap } from '../../styled';
import { NFTItems } from './NFTData';
import NFTItemsCarousel from './NFTItemsCarousel';

const NftItems = () => {
  const [isModal, setModalActive] = useState(false);
  const handleCloseModal = () => setModalActive(false);
  const handleOpenModal = () => setModalActive(true);

  return (
    <>
      <NFTItemsWrap>
        {NFTItems.map(item => (
          <ImageWrapper key={item.id} onClick={handleOpenModal} type="button">
            <img src={item.image} alt={item.name} />
          </ImageWrapper>
        ))}
      </NFTItemsWrap>

      <SimpleModal isActive={isModal} onClose={handleCloseModal}>
        <NFTItemsCarousel />
      </SimpleModal>
    </>
  );
};

export default NftItems;

// region STYLES
const ImageWrapper = styled('button')`
  appearance: none;
  padding: 0;
  margin: 0;
  border-radius: 0;
  border: none;
  background: none;
`;
// endregion


