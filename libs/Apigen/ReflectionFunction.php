<?php

/**
 * ApiGen - API Generator.
 *
 * Copyright (c) 2010 David Grudl (http://davidgrudl.com)
 * Copyright (c) 2011 Ondřej Nešpor (http://andrewsville.cz)
 * Copyright (c) 2011 Jaroslav Hanslík (http://kukulich.cz)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 */

namespace Apigen;

/**
 * Function reflection envelope.
 *
 * Alters TokenReflection\IReflectionFunction functionality for ApiGen.
 *
 * @author Jaroslav Hanslík
 */
class ReflectionFunction extends ReflectionFunctionBase
{
	/**
	 * Returns if the function should be documented.
	 *
	 * @return boolean
	 */
	public function isDocumented()
	{
		if (null === $this->isDocumented && parent::isDocumented()) {
			foreach (self::$config->skipDocPath as $mask) {
				if (fnmatch($mask, $this->reflection->getFilename(), FNM_NOESCAPE | FNM_PATHNAME)) {
					$this->isDocumented = false;
					break;
				}
			}
			if (true === $this->isDocumented) {
				foreach (self::$config->skipDocPrefix as $prefix) {
					if (0 === strpos($this->reflection->getName(), $prefix)) {
						$this->isDocumented = false;
						break;
					}
				}
			}
		}

		return $this->isDocumented;
	}
}
