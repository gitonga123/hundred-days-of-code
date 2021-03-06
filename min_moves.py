arr = [1,2,3]

max_val = max(arr)
count = len(arr) - 1
arr.sort()
moves = 0

while count >= 1:
    moves += arr[count] - arr[0]
    count = count - 1
print(moves)
    