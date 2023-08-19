import React from 'react';
import * as ReactDOM from 'react-dom/client';
import {
  createBrowserRouter,
  RouterProvider,
  Link,
  Navigate,
  BrowserRouter,
  // Router,
  Routes,
  Route,
} from 'react-router-dom';
import Navbar from './navbar';
import Login from './pages/login';
import UserCreate from './pages/user-create';
import UserList from './pages/user-list';
import GuardedRoute from './guarded-route';
import { isUserLogged, isLoggedUserAndHasRole } from '../functions.js';

const router = createBrowserRouter([
  {
    path: '/',
    element: <UserCreate />,
    // element: (
    //   <GuardedRoute guardFunction={() => !isUserLogged()} redirectTo='/home'>
    //     <UserCreate />
    //   </GuardedRoute>
    // ),
    // element: (() => !isUserLogged() ? <UserCreate /> : <Navigate to='/home' replace />)(),
    // element: (
    //   <GuardedRoute 
    //     component={<UserCreate />} 
    //     guardFunction={() => !isUserLogged()} 
    //     redirectTo='/home' 
    //   />
    // ),
  },
  {
    path: '/home',
    element: <h1>Home</h1>,
  },
  {
    path: '/login',
    element: <Login />,
    // element: (
    //   <GuardedRoute guardFunction={() => !isUserLogged()} redirectTo='/home'>
    //     <Login />
    //   </GuardedRoute>
    // ),
    // element: (() => !isUserLogged() ? <Login /> : <Navigate to='/home' replace />)(),
    // element: (
    //   <GuardedRoute 
    //     component={<Login />} 
    //     guardFunction={() => !isUserLogged()} 
    //     redirectTo='/home'
    //   />
    // ),
  },
  {
    path: '/admin',
    element: (
      <GuardedRoute guardFunction={() => isLoggedUserAndHasRole('ROLE_ADMIN')} redirectTo='/login'>
        <UserList />
      </GuardedRoute>
    ),
    // element: (() => isLoggedUserAndHasRole('ROLE_ADMIN') ? <UserList /> : <Navigate to='/login' replace />)(),
    // element: (
    //   <GuardedRoute 
    //     component={<UserList />} 
    //     guardFunction={() => isLoggedUserAndHasRole('ROLE_ADMIN')} 
    //     redirectTo='/login'
    //   />
    // ),
  },
]);

export default function (props) {

  return (
    <React.StrictMode>

        
        {/*<Link to="admin" relative="path">Admin</Link>*/}

      <BrowserRouter>
        <Navbar />
        <Routes>
          <Route path="/" element={(
            <GuardedRoute guardFunction={() => !isUserLogged()} redirectTo='/home'>
              <UserCreate />
            </GuardedRoute>
          )}/>
          <Route path="/login" element={(
            <GuardedRoute guardFunction={() => !isUserLogged()} redirectTo='/home'>
              <Login />
            </GuardedRoute>
          )}/>
          <Route path="/home" element={<h1>Home</h1>}/>
          <Route path="/admin" element={(
            <GuardedRoute guardFunction={() => isLoggedUserAndHasRole('ROLE_ADMIN')} redirectTo='/login'>
              <UserList />
            </GuardedRoute>
          )}/>
        </Routes>
      </BrowserRouter>
      {/*
      <RouterProvider router={router}>
        <Navbar />
      </RouterProvider>
      */}
    </React.StrictMode>
  );
}