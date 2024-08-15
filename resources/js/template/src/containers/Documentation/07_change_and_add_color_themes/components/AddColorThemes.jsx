import React from 'react';
import {
 Card, CardBody, CardTitle, CardTitleWrap, 
} from '@/shared/components/Card';
import CodeHighlither from '@/shared/components/CodeHighlither';
import styled from 'styled-components';

const AddColorThemes = () => (
  <Card height="auto">
    <CardBody>
      <CardTitleWrap>
        <CardTitle>Add Color Theme</CardTitle>
      </CardTitleWrap>
      <p>To create a new color theme for your project you have to:</p>
      <StyledList>
        <ol>
          <li>
            choose a new name for it and create a new action in <b>@/redux</b>;
          </li>
        </ol>
        <CodeHighlither>
          {`// @redux/actions/themeAction.js
import { createAction } from 'redux-actions';

export const changeThemeToDark = createAction('CHANGE_THEME_TO_DARK');
export const changeThemeToLight = createAction('CHANGE_THEME_TO_LIGHT');

// @redux/reducers/themeReducer.js
import { handleActions } from 'redux-actions';
import {
  changeThemeToDark,
  changeThemeToLight,
} from '../actions/themeActions';

const defaultState = {
  className: 'light',
};

export default handleActions(
  {
    [changeThemeToDark]() {
      return { className: 'dark' };
    },
    [changeThemeToLight]() {
      return { className: 'light' };
    },
  },
  defaultState,
);
`}
        </CodeHighlither>
        <ol>
          <li>
            then add new values for each variable in <b>@/utils/palette.js</b>;
          </li>
        </ol>
      </StyledList>
      <p>
        Variables for ltr-rtl are contained in <b>@/utils/directions.js</b>,
        and for shadow and border-radius styles are in <b>@/utils/styles.js</b>.
      </p>
      <p />
      <p>
        For more information read the following documentation:
        {' '}
        <a href="https://styled-components.com/docs/advanced#theming" target="_blank" rel="noreferrer">
          https://styled-components.com/docs/advanced#theming
        </a>
      </p>
    </CardBody>
  </Card>
);

export default AddColorThemes;

// region STYLES

const StyledList = styled('div')`
  ol {
    margin-bottom: 5px;
  }
`;

// endregion
