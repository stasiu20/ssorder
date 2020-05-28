import {
    applyMiddleware,
    combineReducers,
    compose,
    createStore,
    Store,
} from 'redux';
import thunk from 'redux-thunk';
import { AppState } from './types';
import { dictReducer } from './dictionary';

// prettier-ignore
// eslint-disable-next-line @typescript-eslint/no-explicit-any
const composeEnhancers = (typeof window !== 'undefined' && (window as any).__REDUX_DEVTOOLS_EXTENSION_COMPOSE__) || compose;
function configureStore(): Store<AppState> {
    return createStore(
        combineReducers<AppState>({ dict: dictReducer }),
        composeEnhancers(applyMiddleware(thunk)),
    );
}

const store = configureStore();
export default store;
