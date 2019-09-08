<?php

namespace Client\Controllers;

use Common\Controller;

class HomeController extends Controller
{
		public function homepage()
		{
				$user = 'stuff';

				return view('client/home/show', compact('user'));
		}
}
