import React from 'react';
import {
 Card, CardBody, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';
import CodeHighlither from '@/shared/components/CodeHighlither';
import styled from 'styled-components';

const ChangeColorThemes = () => (
  <Card height="auto">
    <CardBody>
      <CardTitleWrap>
        <CardTitle>Change Color Theme</CardTitle>
      </CardTitleWrap>
      <p>EasyDev uses <a href="https://styled-components.com/" target="_blank" rel="noreferrer">styled-components</a>
        {' '}to create styles so that you can easily manage your project&apos;s colors and other style things.
      </p>
      <p>This template contains dark and light themes. All style variables are contained
        in <b>@/utils/</b> folder, and actions to change between them are located in @/redux.
      </p>
      <p>So you can change values of the variables as you want or add new ones. There for types of the variables:</p>
      <StyledList>
        <ol>
          <li><b>Mode</b> for colors;</li>
        </ol>
        <CodeHighlither>
          {`const colorBackground = theme('mode', {
  light: 'white',
  dark: '#232329',
});`}
        </CodeHighlither>
        <ol>
          <li>Actually you can use colors that doesn&apos;t depends on theme</li>
        </ol>
        <CodeHighlither>
          {'export const colorAccent = \'#4ce1b6\';'}
        </CodeHighlither>
        <ol>
          <li>If you need to create color that need to be <b>darken</b> or <b>lighten</b> that original color{' '}
            you need to use methods with same names:
          </li>
        </ol>
        <CodeHighlither>
          {`import { darken, lighten } from 'polished';

export const buttonBackgroundHover = theme('mode', {
  light: darken(0.05, '#f2f4f7'),
  dark: lighten(0.05, '#2a2a31'),
});`}
        </CodeHighlither>
        <ol>
          <li>Also you can use css functions to create colors:</li>
        </ol>
        <CodeHighlither>
          {`export const colorBubble = theme('mode', {
  light: 'rgba(242, 244, 247, 0.65)',
  dark: 'rgba(68, 79, 97, 0.65)',
});`}
        </CodeHighlither>
        <ol>
          <li>As you can use <b>mode</b> for change color you can use it to change images that depends on theme:
          </li>
        </ol>
        <CodeHighlither>
          {`export const image = theme('mode', {
  light: \`url(\${process.env.PUBLIC_URL}/img/image.svg)\`,
  dark: \`url(\${process.env.PUBLIC_URL}/img/image.svg)\`,
});`}
        </CodeHighlither>

        <ol>
          <li><b>Direction</b> for styles depending on rtl and ltr view;</li>
        </ol>
        <CodeHighlither>
          {`const YouAwesomeComponent = () => {
  const { rtl } = useSelector(state => ({ rtl: state.rtl }));
  
  const dispatch = useDispatch();
  
  const changeToRTL = () => {
    dispatch(changeDirectionToRTL());
  };
  
  const changeToLTR = () => {
    dispatch(changeDirectionToLTR());
  };

  return (
    <SomeStyledComponentWrap>
      <Toggle
        title="RTL mode"
        name="direction_toggle"
        onChange={rtl.direction === 'rtl' ? changeToLTR : changeToRTL}
        checked={rtl.direction === 'rtl'}
        id="direction_toggle"
      />
    </SomeStyledComponentWrap>
  );
};
`}
        </CodeHighlither>
        <ol>
          <li><b>Shadow</b> to choose between designs with and without shadows;</li>
        </ol>
        <CodeHighlither>
          {`export const shadow = theme('shadow', {
  on: '0 10px 30px 1px rgba(0, 0, 0, 0.06)',
  off: 'none',
});`}
        </CodeHighlither>
        <ol>
          <li><b>Border</b> to choose between styles with and without border radius.</li>
        </ol>
        <CodeHighlither>
          {`export const borderRadius = theme('border', {
  on: '15px',
  off: '5px',
});`}
        </CodeHighlither>
      </StyledList>
    </CardBody>
  </Card>
);

export default ChangeColorThemes;

// region STYLES

const StyledList = styled('div')`
  ol {
    margin-bottom: 5px;
  }
`;

// endregion
