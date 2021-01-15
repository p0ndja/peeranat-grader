if (i > 0 and (num[i-1] == '+' or num[i-1] == '-' or num[i-1] == '*' or num[i-1] == '/' or num[i-1] == '^' or num[i-1] == 'sqrt')):
        o = operate(num[i-2], num[i-1], num[i])
        print(num[i-2], num[i-1], num[i], '=', o)
        num[i] = o
    if (o == 'Error'):
      break